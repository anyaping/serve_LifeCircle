<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Carousel extends Controller
{

	/**
    *  遍历前台各栏目对应的轮播图
    */
    public function select(){
    	$column_id = request()->post('id'); 
    	$result = Db::table('lf_carousel')
    			->alias('n')
    			->join('lf_column c','n.carousel_columnid = c.id') 
    			->where('n.carousel_columnid = '.$column_id)
    			->field('n.carousel_img,c.column_name')
    			->select();
    	$respone = array('data' => $result, 'result' => '200', 'msg' => '查询成功');
        return json_encode($respone);
    }

     /**
     * 二手市场---发布话题页面接口
     */
    public function add_topic()
    {
        $data = request()->post();

        if (!$data['uid'] || !$data['content'] || !$data['columnid']) {
            $respone = array('data' => '', 'code' => 400, 'msg' => '必填参数不能为空');
            return json_encode($respone);
        }

        if (request()->file('file')) {
            $file = $this->upload('file');
            if ($file['status'] === 1) {
                $data['file'] = $file['message'];
            }else{
                $respone = array('data' => '', 'result' => '-2', 'msg' => $file['message']);
                return json_encode($respone);
            }
        }

        if($data['phone']){
            if(!preg_match('/^(13|14|15|17|18)[0-9]{9}$/',$data['phone'])){
                $respone = array('data' => '', 'result' => '-2', 'msg' => '手机号格式不正确');
                return json_encode($respone);
            }
        }
        


        $data['add_time'] = time();
        $add = Db::name('topic_list')->insertGetId($data);
        if($add){
            $respone = array('data' => $add, 'result' => '1', 'msg' => '添加成功');
            return json_encode($respone);

        }else{
            $respone = array('data' => '', 'result' => '-1', 'msg' => '添加失败');
            return json_encode($respone);
        }

    }


    /**
    *  发布信息上传文件
    */
    public function upload($param=''){
        $respone['message'] = '';
        // 获取表单上传文件
        $files = request()->file($param);
        if(is_array($files)){
            foreach($files as $file){
                // 移动到框架应用根目录/public/upload/ 目录下
                $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'upload');
                if($info){
                    // 成功上传后 获取上传信息
                    $respone['message'] .= $info->getSaveName().",";
                    $respone['status'] = 1;
                }else{
                    // 上传失败获取错误信息
                    $respone['message'] = $info->getError();
                    $respone['status'] = 0;
                }    
            }

            if ($respone['status'] === 1) {
                $respone['message'] = rtrim($respone['message'], ',');
            }
        }else if($files){
            $info = $files->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'upload');
            $respone['message'] = $info->getSaveName();
            $respone['status'] = 1;
        }else{
            $info = $files->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'upload');
            // 上传失败获取错误信息
            $respone['message'] = $info->getError();
            $respone['status'] = 0;
        }  

        return $respone;
    }

    
}