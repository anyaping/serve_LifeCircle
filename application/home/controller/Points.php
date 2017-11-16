<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Points extends Controller
{


    /**
    *  我的积分页面接口
    */
    public function find()
    {
    	$data = input('post.');
        $time = time();

        if(empty($data['id'])){
            $respone = array('data' => '', 'result' => '-2', 'msg' => '缺少参数');
            return json_encode($respone);
        }

        $result = Db::name('user')->where('id',$data['id'])->value('points');

        $datas = ['id' => $data['id'], 
                  'points' => $result];
        
        if($result){
            $respone = array('data' => $datas, 'result' => '1', 'msg' => '查询成功');
            return json_encode($respone);

        }else{
            $respone = array('data' => '', 'result' => '-1', 'msg' => '查询失败');
            return json_encode($respone);
        }
    }



}