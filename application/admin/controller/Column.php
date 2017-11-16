<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Paginator;
use \think\render;
class Column extends controller
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
     * 加载栏目管理页面
     */
    public function index(){
        $result = Db::name('column')->paginate(8);
        $page = $result->render();
        $this->assign('page',$page);
        $this->assign('results',$result);
        return $this->view->fetch();
    }

    /**
     * 点击添加弹出layer页面
     */
    public function add(){
        return $this->view->fetch();
    }

    /**
     * 执行添加栏目
     */
    public function doAdd(){
        $column_name = request()->post('column_name');
        $column_logo = $this->upload();

        if(!$column_name){
            $respone = array('status' => 400, 'msg' => '请完善信息');
            return $respone;
            exit;
        }

        if ($column_logo['status'] == 400) {
            return $column_logo;
            exit;
        }

        $data = array('column_name' => $column_name, 'column_logo' => $column_logo['message']);

        $result = Db::name('column')->insert($data);
        if($result){
            $respone = array('status' => 200, 'msg' => '添加成功');
        }else{
            $respone = array('status' => 400, 'msg' => '添加失败');
        }
        return $respone;
        exit;
    }


    /**
    *  点击修改弹出layer页面
    */
    public function edit(){
        $id = input('get.id');
        $result = Db::name('column')->where('id',$id)->find();
        $this->assign('results',$result);
        return $this->view->fetch();
    }

    /**
     * 执行修改栏目
     */
    public function doedit(){
        $id = request()->post('id');
        $column_name = request()->post('column_name');
        $column_logo = $this->upload();

        if(!$column_name){
            $respone = array('status' => 400, 'msg' => '请完善信息');
            return $respone;
            exit;
        }

        if ($column_logo['status'] == 400) {
            return $column_logo;
            exit;
        }

        $data = array('column_name' => $column_name, 'column_logo' => $column_logo['message']);
        $old_logo = Db::name('column')->where('id',$id)->value('column_logo');
        if($old_logo){
            unlink("upload/".$old_logo);
        }

        $result = Db::name('column')->where('id',$id)->update(['column_name'  => $column_name,'column_logo' => $column_logo['message'],]);
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
        $result = Db::name('column')->where('id',$id)->delete();
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
        $file = request()->file('column_logo');
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
