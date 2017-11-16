<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Address extends Controller
{


    /**
    *  新增地址页面接口
    */
    public function insert()
    {
    	$data = input('post.');
        $time = time();

        if(empty($data['address_uid']) || empty($data['address_name']) || empty($data['address_phone']) || empty($data['address_address']) || empty($data['address_number'])){
            $respone = array('data' => '', 'result' => '-2', 'msg' => '缺少参数');
            return json_encode($respone);
        }



        if(!preg_match('/^(13|14|15|17|18)[0-9]{9}$/',$data['address_phone'])){
            $respone = array('data' => '', 'result' => '-2', 'msg' => '手机号格式不正确');
            return json_encode($respone);
        }

        $datas = ['address_uid' => $data['address_uid'], 
                  'address_name' => $data['address_name'], 
                  'address_phone' => $data['address_phone'], 
                  'address_address' => $data['address_address'], 
                  'address_number' => $data['address_number'],
                  'address_time' => $time];

        $result = Db::name('address')->insert($datas);
        
        if($result){
            $respone = array('data' => $datas, 'result' => '1', 'msg' => '添加成功');
            return json_encode($respone);

        }else{
            $respone = array('data' => '', 'result' => '-1', 'msg' => '添加失败');
            return json_encode($respone);
        }
    }



}
 