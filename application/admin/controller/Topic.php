<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\render;
class Topic extends controller
{
    /**
     * 初始化方法
     */
    public function _initialize(){
        $request = Request::instance();
        if(session('user')){
            $this->username = session('user')['username'];
            $this->assign('username',$this->username);
        }else{
            $controller = $request->controller();
            if($controller != 'Login'){
                return $this->redirect('Login/index');
            } 
        }
    }

    /**
     * 加载话题管理页面
     */
    public function index(){
        $result = Db::table('lf_topic')
                ->alias('t')
                ->join('lf_column c','t.topic_columnid = c.id','LEFT')
                ->field('t.id,t.topic_img,t.topic_name,c.column_name,t.topic_attend,t.topic_dynamic')
                ->paginate(8);
        $page = $result->render();
        $this->assign('page',$page);
        $this->assign('results',$result);
        return $this->view->fetch();
    }

    /**
     * 点击添加弹出layer页面
     */
    public function add(){
        $columns = Db::name('column')->field('id, column_name')->select();
        $this->assign('columns', $columns);
        return $this->view->fetch();
    }

    /**
     * 执行添加话题
     */
    public function doAdd(){
        $data = request()->post();
        $topic_img = $this->upload();

        if(!$data['topic_name'] || !$data['topic_column']){
            $respone = array('status' => 400, 'msg' => '请完善信息');
            return $respone;
            exit;
        }

        if ($topic_img['status'] == 400) {
            return $topic_img;
            exit;
        }

        $results = Db::name('column')->where('id',$data['topic_column'])->find();

        if($results){
            $datas = array( 'topic_img' => $topic_img['message'], 'topic_name' => $data['topic_name'], 'topic_columnid' => $data['topic_column']);

            $result = Db::name('topic')->insert($datas);
            if($result){
                $respone = array('status' => 200, 'msg' => '添加成功');
            }else{
                $respone = array('status' => 400, 'msg' => '添加失败');
            }
        }else{
            $respone = array('status' => 400, 'msg' => '你所填的栏目不存在');
        }
        return $respone;
        exit;
    }


    /**
    *  点击修改弹出layer页面
    */
    public function edit(){
        $id = input('get.id');
        $result = Db::table('lf_topic')
                ->field('id,topic_img,topic_name,topic_columnid')
                ->where('id',$id)
                ->find();

        $columns = Db::name('column')->field('id, column_name')->select();
        $this->assign('columns', $columns);
        $this->assign('results',$result);
        return $this->view->fetch();
    }

    /**
     * 执行修改话题
     */
    public function doedit(){
        $id = request()->post('id');
        $data = request()->post();
        $topic_img = $this->upload();

        if(!$topic_img || !$data['topic_name'] || !$data['topic_column']){
            $respone = array('status' => 400, 'msg' => '请完善信息');
            return $respone;
            exit;
        }

        if ($topic_img['status'] == 400) {
            return $topic_img;
            exit;
        }

        $results = Db::name('column')->where('id',$data['topic_column'])->value('id');
        if($results){
            $old_logo = Db::name('topic')->where('id',$id)->value('topic_img');
            if($old_logo){
                unlink("upload/".$old_logo);
            }

            $result = Db::table('lf_topic')->where('id',$id)->update(['topic_img'  => $topic_img['message'],'topic_name' => $data['topic_name'],'topic_columnid' => $results,]);
            if($result){
                $respone = array('status' => 200, 'msg' => '修改成功');
            }else{
                $respone = array('status' => 400, 'msg' => '修改失败');
            }
        }else{
            $respone = array('status' => 400, 'msg' => '您所填写的栏目不存在');
        }
        
        return $respone;
        exit;
    }

    

    /**
    *  执行删除
    */
    public function del(){
        $id = input('get.id');
        if(!$id){
            return $data = "id为空";
        }
        $result = Db::name('topic')->where('id',$id)->delete();
        if($result){
            return $data = 1;
        }else{
            return $data = 0;
        }
    }

    /**
    *  上传图片
    */
    public function upload(){
        $file = request()->file('topic_img');
        // 移动到框架应用根目录/public/upload/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
        if($info){
            $respone['message'] = $info->getSaveName();
            $respone['status'] = 200;
            return $respone;
        }
        $respone['message'] = $info->getError();
        $respone['status'] = 400;
        return $respone;
    }

}
