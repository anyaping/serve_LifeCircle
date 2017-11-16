<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Column extends Controller
{

	/**
    *  遍历前台栏目接口
    */
    public function select(){
    	$result = Db::name('column')->select();
    	$respone = array('data' => $result, 'result' => '200', 'msg' => '查询成功');
        return json_encode($respone);
    }

    
}