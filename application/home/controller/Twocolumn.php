<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Twocolumn extends Controller
{

	/**
    *  遍历二级栏目
    */
    public function select(){
    	$column_id = request()->post('id'); 
    	$result = Db::table('lf_twocolumn')
    			->alias('t')
    			->join('lf_column c','t.twocolumn_pid = c.id') 
    			->where('t.twocolumn_pid = '.$column_id)
    			->field('t.id,c.column_name,t.twocolumn_name,t.twocolumn_img')
    			->select();
    	$respone = array('data' => $result, 'result' => '200', 'msg' => '查询成功');
        return json_encode($respone);
    }

    
}