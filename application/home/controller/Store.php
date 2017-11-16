<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Store extends Controller
{

	/**
    *  查询便利店商品类型接口
    */
    public function select_type(){
    	$data = Db::name('storetype')->column('id,type_name');
    	$respone = array('data' => $data, 'result' => '200', 'msg' => '查询成功');
        return json_encode($respone);
    }


	/**
    *  查询便利店商品接口
    */
    public function select(){
    	$list = [];
    	$data = Db::table('lf_store')
    			->alias('s')
    			->join('lf_storetype t','s.store_type = t.id') 
    			->field('s.id,s.store_name,s.store_img,s.store_price,s.store_number,t.type_name,s.store_time')
    			->select();
    	foreach($data as $k => $v){
    		$list[$v['type_name']][] = $v;
    	}
    	$respone = array('data' => $list, 'result' => '200', 'msg' => '查询成功');
        return json_encode($respone);
    }

    /**
    *  商品加入购物车接口
    */
    public function insert(){
        $data = input('post.');
        $time = time();

        if(empty($data['shop_id']) || empty($data['uid'])){
            retData('必填参数为空', 400);
        }

        $shop_price = Db::name('store')->where('id', $data['shop_id'])->value('store_price');

        if(isset($shop_price)){
            $map = ['uid' => $data['uid'], 'shop_id' => $data['shop_id']];

            $info = Db::name('shopcar')->where($map)->find();

            if($info){

                $saveData['shop_num'] = $info['shop_num']+1;
                $saveData['shop_price'] = $shop_price * $saveData['shop_num'];


                $save = Db::name('shopcar')
                        ->where($map)
                        ->update($saveData);

            }else{

                $saveData = ['uid' => $data['uid'], 
                          'shop_id' => $data['shop_id'], 
                          'shop_num' => 1,
                          'shop_price' => $shop_price,
                          'shop_time' => $time];

                $save = Db::name('shopcar')->insertGetId($saveData);
            }

            if (!$save) {
                retData('添加购物车失败', 400);
            }

            retData('success', 200);
        }else{
            retData('该商品不存在', 400);
        }

    }

    
    /**
    *  购物车页面接口
    */
    public function select_car(){
        $data = input('post.');

        if(empty($data['uid'])){
            retData('必填参数为空', 400);
        }

        $data = Db::table('lf_store')
                ->alias('s')
                ->join('lf_shopcar c','c.shop_id = s.id') 
                ->field('c.id,s.store_img,s.store_name,s.store_price,c.shop_num')
                ->select();

         retData($data, 200);
    }


    /**
    *  购物车页面删除操作接口
    */
    public function cardel(){
        $data = input('post.');

        if(empty($data['id'])){
            retData('必填参数为空', 400);
        }

        $result = Db::name('shopcar')->where('id',$data['id'])->delete();
        if($result){
            retData('删除成功', 200);
        }else{
            retData('删除失败', 400);
        }
        
    }


    /**
    *  购物车页面提交订单操作接口
    */
    public function car_submit(){

        $data = input('post.');
        $insertData['time'] = time();
        $shop = json_decode($data['shop'], true);
        $insertData['order_number'] = date('Ymdhis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        foreach ($shop as $k => $v) {
            Db::startTrans();
            $insertData['shop_id'] = $v['shop_id'];
            $insertData['shop_num'] = $v['shop_num'];
            $insertData['total_price'] = $v['total_price'];


            $insertData['uid'] = $data['uid'];
            $insertData['pay_type'] = $data['pay_type'];
            $insertData['address'] = $data['address'];
            $insertData['ps'] = $data['ps'];


            $insert = Db::name('ordernumber')->insert($insertData);
        }

        if (!$insert) {
            Db::rollback();
            retData('添加失败', 400);
        }
        Db::commit();
        retData('添加成功', 200);

    }


    /**
    *  我的订单页面接口
    */
    public function order_number(){

        $data = input('post.');

        if(empty($data['uid'])){
            retData('必填参数为空', 400);
        }

        $result = Db::table('lf_ordernumbers')
                ->alias('o')
                ->join('lf_ordernumber s','o.order_number = s.order_number') 
                ->join('lf_store t','s.shop_id = t.id') 
                ->field('o.id,t.store_name,t.store_img,t.store_price,s.shop_num,o.status')
                ->select();

        if($result){    
            retData($result, 200);
        }else{
            retData('查询失败', 400);
        }

    }


}
