<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Topic extends Controller
{

	/**
    *  遍历前台各栏目对应的话题
    */
    public function select(){
    	$column_id = request()->post('id');
    	$result = Db::table('lf_topic')
    			->alias('t')
    			->join('lf_column c','t.topic_columnid = c.id') 
    			->where('t.topic_columnid = '.$column_id)
    			->field('t.topic_img,t.topic_name,c.column_name,t.topic_attend,t.topic_dynamic')
    			->select();
    	$respone = array('data' => $result, 'result' => '200', 'msg' => '查询成功');
        return json_encode($respone);
    }

    /**
    *  话题->我的话题接口
    */
    public function insert()
    {
        $data = input('post.');
        $time = time();

        if(empty($data['topic_id']) || empty($data['topic_content'])){
            $respone = array('data' => '', 'result' => '-2', 'msg' => '缺少参数');
            return json_encode($respone);
        }

        //上传图片 
        if (request()->file('topic_img')) {
            $info   =   $this->upload();
            if ($info['status'] === 1) {
                $data['img'] = $info['message'];
            }else{
                $respone = array('data' => '', 'result' => '-2', 'msg' => $info['message']);
                return json_encode($respone);
            }
        }

        $datas = ['topic_img' => $data['img'], 
                  'topic_name' => $data['topic_id'], 
                  'topic_content' => $data['topic_content'], 
                  'topic_address' => $data['topic_address'], 
                  'topic_link' => $data['topic_link']];

        $result = Db::name('topic')->insert($datas);
        
        if($result){
            $respone = array('data' => $datas, 'result' => '1', 'msg' => '添加成功');
            return json_encode($respone);

        }else{
            $respone = array('data' => '', 'result' => '-1', 'msg' => '添加失败');
            return json_encode($respone);
        }
    }

    /**
    *  发布信息上传图片
    */
    public function upload(){
        $respone['message'] = '';
        // 获取表单上传文件
        $files = request()->file('topic_img');
        if(is_array($files)){
            foreach($files as $file){
                // 移动到框架应用根目录/public/upload/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
                if($info){
                    // 成功上传后 获取上传信息
                    $respone['message'] .= $info->getSaveName().",";
                    $respone['status'] = 1;
                }else{
                    // 上传失败获取错误信息
                    $respone['message'] = $file->getError();
                    $respone['status'] = 0;
                }    
            }
            if ($respone['status'] === 1) {
                $respone['message'] = rtrim($respone['message'], ',');
            }
            return $respone;
        }
        
    }

    

    
}