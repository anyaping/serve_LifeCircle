<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Note extends Controller
{

	/**
    *  遍历前台各个栏目对应帖子接口
    */
    public function select(){
    	$column_id = request()->post('id');
    	$result = Db::table('lf_note')
    			->alias('n')
    			->join('lf_column c','n.note_columnid = c.id') 
    			->where('n.note_columnid = '.$column_id)
    			->field('n.note_title,n.note_img,n.note_content,n.note_auth,c.column_name,n.note_time,n.note_stick,n.note_points')
    			->select();

    	if ($result) {
    		foreach ($result as $k => $v) {
    			$result[$k]['note_time'] = date('Y-m-d', $v['note_time']);
    		}
    	}else{
    		$result = array();
    	}
    	
    	$respone = array('data' => $result, 'result' => '200', 'msg' => '查询成功');
        return json_encode($respone);
    }



    /**
    *  我的帖子页面接口
    */
    public function find(){
        $id = request()->post('id');

        $result = Db::table('lf_note')
                ->alias('n')
                ->join('lf_column c','n.note_columnid = c.id') 
                ->join('lf_user u','n.note_uid = u.id') 
                ->where('n.note_uid = '.$id)
                ->field('n.note_title,n.note_img,n.note_content,u.name,c.column_name,n.note_time')
                ->select();

        if ($result) {
            foreach ($result as $k => $v) {
                $result[$k]['note_time'] = date('Y-m-d H:i', $v['note_time']);
            }
        }else{
            $result = array();
        }
        $respone = array('data' => $result, 'result' => '200', 'msg' => '查询成功');
        return json_encode($respone);
    }





}