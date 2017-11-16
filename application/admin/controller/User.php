<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\render;
class User extends controller
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
     * 加载帖子管理页面
     */
    public function index(){

        $result = Db::name('user')->order('id desc')->paginate(8);
        $page = $result->render();
        $this->assign('page',$page);
        $this->assign('results',$result);
        return $this->view->fetch();
    }

    /**
     * 加载用户管理页面
     */
    public function sort(){
        $sort = request()->post('sort');

        $result = Db::name('user')->order('money '.$sort)->paginate(8);
        $this->assign('results',$result);
        $respone['html'] = $this->view->fetch();
        return $respone;
    }
}
