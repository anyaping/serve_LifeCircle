<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
class Index extends controller
{
    private $username;
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
     * 加载后台首页
     */
    public function index()
    {
        return $this->view->fetch();
    }

    /**
     * 加载后台首页
     */
    public function home_page()
    {
        return $this->view->fetch();
    }
    
}
