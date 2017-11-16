<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Back extends Controller
{


    /**
    *  意见反馈页面接口
    */
    public function insert()
    {
    	$data = input('post.');
        $time = time();

        if(empty($data['back_uid']) || empty($data['back_content']) || empty($data['back_email'])){
            $respone = array('data' => '', 'result' => '-2', 'msg' => '缺少参数');
            return json_encode($respone);
        }



        if(!preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i',$data['back_email'])){
            $respone = array('data' => '', 'result' => '-2', 'msg' => '您输入的邮箱格式不合法');
            return json_encode($respone);
        }

        $datas = ['back_uid' => $data['back_uid'], 
                  'back_content' => $data['back_content'], 
                  'back_email' => $data['back_email'], 
                  'back_time' => $time];

        $result = Db::name('back')->insert($datas);
        
        if($result){
            $respone = array('data' => $datas, 'result' => '1', 'msg' => '添加成功');
            return json_encode($respone);

        }else{
            $respone = array('data' => '', 'result' => '-1', 'msg' => '添加失败');
            return json_encode($respone);
        }
    }



}