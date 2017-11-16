<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;

class Login extends controller
{
    public function index()
    {
        return $this->fetch();
    }

    //执行登录
    public function dologin(){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $list = Db::name('root')
                ->where(array('username' => $username, 'password' => $password))
                ->find();
        //判断是否获取登录用户信息
        if($list){
            //此处表示登录成功
            session("user",$list); //放置登录信息
            $respone = array('status' => 200, 'msg' => '登录成功');
            return $respone;
        }else{
            $respone = array('status' => 400, 'msg' => '账号或者密码错误');
            return $respone;
        }
    }
}