<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\render;
class Carousel extends controller
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
     * 加载轮播图管理页面
     */
    public function index(){

        $results = Db::table('lf_carousel')
                ->alias('a')
                ->join('lf_column n','a.carousel_columnid = n.id', 'LEFT')
                ->field('n.column_name,a.id,a.carousel_img')
                ->paginate(8);
        $page = $results->render();
        $this->assign('page',$page);
        $this->assign('results',$results);
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
     * 执行添加轮播图
     */
    public function doAdd(){
        $carousel_column = request()->post('carousel_column');
        $carousel_img = $this->upload();

        if(!$carousel_column){
            $respone = array('status' => 400, 'msg' => '请完善信息');
            return $respone;
            exit;
        }

        if ($carousel_img['status'] == 400) {
            return $carousel_img;
            exit;
        }

        $results = Db::name('column')->where('id',$carousel_column)->find();

        if($results){
            $data = array('carousel_columnid' => $carousel_column, 'carousel_img' => $carousel_img['message']);

            $result = Db::name('carousel')->insert($data);
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
        $result = Db::name('carousel')
                ->field('id,carousel_columnid')
                ->where('id',$id)
                ->find();

        $columns = Db::name('column')->field('id, column_name')->select();
        $this->assign('columns', $columns);
        $this->assign('results',$result);
        return $this->view->fetch();
    }

    /**
     * 执行修改轮播图
     */
    public function doedit(){
        $id = request()->post('carousel_id');
        $carousel_column = request()->post('carousel_column');
        $carousel_img = $this->upload();

        if(!$carousel_column){
            $respone = array('status' => 400, 'msg' => '请完善信息');
            return $respone;
            exit;
        }

        if ($carousel_img['status'] == 400) {
            return $carousel_img;
            exit;
        }

        $results = Db::name('column')->where('id',$carousel_column)->value('id');

        if($results){
            $old_logo = Db::name('carousel')->where('id',$id)->value('carousel_img');
            if($old_logo){
                unlink("upload/".$old_logo);
            }

            $result = Db::name('carousel')->where('id',$id)->update(['carousel_columnid'  => $results,'carousel_img' => $carousel_img['message'],]);
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
        $result = Db::name('carousel')->where('id',$id)->delete();
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
        $file = request()->file('carousel_img');
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
