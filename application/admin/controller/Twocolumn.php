<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Paginator;
use \think\render;
class Twocolumn extends controller
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
     * 
     * 加载二级栏目管理页面
     */
    public function index(){
        $result = Db::name('twocolumn')->paginate(8);

        $list = [];

        foreach ($result as $k => $v) {
            $list[$k] = $v;
            $list[$k]['leader_name'] = Db::name('column')->where('id', $v['twocolumn_pid'])->value('column_name');
        }
        $page = $result->render();
        $this->assign('page',$page);
        $this->assign('result',$result);
        $this->assign('results',$list);
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
     * 执行添加栏目
     */
    public function doAdd(){
        $data = request()->post();
        $twocolumn_img = $this->upload();

        if(!$data){
            $respone = array('status' => 400, 'msg' => '请完善信息');
            return $respone;
            exit;
        }

        if ($twocolumn_img['status'] == 400) {
            return $twocolumn_img;
            exit;
        }

        $results = Db::name('column')->where('id',$data['twocolumn_pid'])->value('id');

        if($results){
            $datas = array('twocolumn_name' => $data['twocolumn_name'],'twocolumn_pid' => $results, 'twocolumn_img' => $twocolumn_img['message']);

            $result = Db::name('twocolumn')->insert($datas);
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
        $result = Db::name('twocolumn')
                ->field('id,twocolumn_name,twocolumn_img,twocolumn_pid')
                ->where('id',$id)
                ->find();

        $columns = Db::name('column')->field('id, column_name')->select();
        $this->assign('columns', $columns);
        $this->assign('results',$result);
        return $this->view->fetch();
    }

    /**
     * 执行修改栏目
     */
    public function doedit(){
        $id = request()->post('twocolumn_id');
        $data = request()->post();
        $twocolumn_img = $this->upload();

        if(!$data){
            $respone = array('status' => 400, 'msg' => '请完善信息');
            return $respone;
            exit;
        }

        if ($twocolumn_img['status'] == 400) {
            return $column_logo;
            exit;
        }

        $old_logo = Db::name('column')->where('id',$id)->value('column_logo');
        if($old_logo){
            unlink("upload/".$old_logo);
        }

        $result = Db::name('twocolumn')->where('id',$id)->update(['twocolumn_name'  => $data['twocolumn_name'],'twocolumn_img' => $twocolumn_img['message'],'twocolumn_pid' => $data['twocolumn_pid'],]);
        if($result){
            $respone = array('status' => 200, 'msg' => '修改成功');
        }else{
            $respone = array('status' => 400, 'msg' => '修改失败');
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
        $result = Db::name('twocolumn')->where('id',$id)->delete();
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
        $file = request()->file('twocolumn_img');
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
