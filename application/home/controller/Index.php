<?php

namespace app\home\controller;

use think\Controller;
use think\Validate;
use think\Db;

class Index extends Controller
{

	/**
    *  添加用户信息
    */
    public function index(){
    	return $this->fetch();
    }

    /**
    *  添加用户信息
    */
    public function insert()
    {
    	$data = input('post.');
        $time = time();

    	$post = ['name', 'abstract', 'sex', 'birthday', 'address1','address2', 'phone','email'];

        foreach ($post as $k => $v) {
            if (!isset($data[$v])) {
                $respone = array('data' => '', 'result' => '-2', 'msg' => '缺少参数'.$v);
                return json_encode($respone);
            }   
        }
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $respone = array('data' => '', 'result' => '-2', 'msg' => $key.'参数为空！');
                return json_encode($respone);
            }
        }

        if(!preg_match('/^(13|14|15|17|18)[0-9]{9}$/',$data['phone'])){
            $respone = array('data' => '', 'result' => '-2', 'msg' => '手机号格式不正确');
            return json_encode($respone);
        }

        if(!preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i',$data['email'])){
            $respone = array('data' => '', 'result' => '-2', 'msg' => '您输入的邮箱格式不合法');
            return json_encode($respone);
        }

        
        //上传图片
        if (request()->file('img')) {
            $info   =   $this->upload();
            if ($info['status'] === 1) {
                $data['img'] = $info['message'];
            }else{
                $respone = array('data' => '', 'result' => '-2', 'msg' => '头像上传失败');
                return json_encode($respone);
            }
        }

        $result = Db::name('user')->where('phone',$data['phone'])->update([
                                            'img'  => $data['img'],
                                            'name'  => $data['name'],
                                            'abstract' => $data['abstract'],
                                            'sex'  => $data['sex'],
                                            'birthday' => $data['birthday'],
                                            'address1'  => $data['address1'],
                                            'address2' => $data['address2'],
                                            'email'  => $data['email'],
                                            'time'  => $time,
                                            ]);

        
        if($result){
            $respone = array('data' => $data, 'result' => '1', 'msg' => '添加成功');
            return json_encode($respone);

        }else{
            $respone = array('data' => '', 'result' => '-1', 'msg' => '添加失败');
            return json_encode($respone);
        }
    }

    /**
    *  用户编辑修改信息查询用户信息
    */
    public function edit()
    {
        $data = input('post.phone');
        $result = Db::name('user')->where('phone',$data)->find();
        if ($result) {
            $result['time'] = date('Y-m-d', $result['time']);
        }
        $respone = array('data' => $result, 'result' => '1', 'msg' => '查询成功');
        return json_encode($respone);
    }  
  


    /**
    *  用户上传头像
    */
    public function upload(){
        $file = request()->file('img');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->rule('md5')->move(ROOT_PATH . 'public' . DS . 'upload');
        if($info){
            $respone['message'] = $info->getSaveName();
            $respone['status'] = 1;
            return $respone;
        }
        $respone['status'] = 0;
        return $respone;
    }

    /**
    *  验证验证码接口
    */
    public function verify()
    {
        $data = input('post.');
        $result1 = Db::name('user')->where('phone',$data['phone'])->find();
        if($result1){
            $result = Db::name('verify_code')->where('phone',$data['phone'])->find();
            $add_time = $result['add_time']+180;
            if(!$result){
                $respone = array('data' => $data['phone'], 'result' => '400', 'msg' => '验证码发送失败');
                return json_encode($respone);
            }else{
                if($add_time < time()){
                    $respone = array('data' => $data['code'], 'result' => '400', 'msg' => '手机验证码已失效');
                    return json_encode($respone);
                }else{
                    if($result['code'] == $data['code']){
                        $respone = array('data' => $data['code'], 'result' => '200', 'msg' => '验证码填写正确');
                        return json_encode($respone);
                    }else{
                        $respone = array('data' => $data['code'], 'result' => '400', 'msg' => '验证码填写错误');
                        return json_encode($respone);
                    }
                }
            }
        }else{
            $result = Db::name('verify_code')->where('phone',$data['phone'])->find();
            $add_time = $result['add_time']+180;
            if(!$result){
                $respone = array('data' => $data['phone'], 'result' => '400', 'msg' => '验证码发送失败');
                return json_encode($respone);
            }else{
                if($add_time < time()){
                    $respone = array('data' => $data['code'], 'result' => '400', 'msg' => '手机验证码已失效');
                    return json_encode($respone);
                }else{
                    if($result['code'] == $data['code']){
                        $datas = ['phone' => $data['phone']];
                        $results = Db::name('user')->insert($datas);
                        $respone = array('data' => $data['code'], 'result' => '200', 'msg' => '验证码填写正确');
                        return json_encode($respone);
                    }else{
                        $respone = array('data' => $data['code'], 'result' => '400', 'msg' => '验证码填写错误');
                        return json_encode($respone);
                    }
                }
            }
        }
        
    }  

    /**
     * 调用短信接口
     */
    public function sendsms()
    {
        $phone = request()->post('phone');

        if(!preg_match('/^(13|14|15|17|18)[0-9]{9}$/',$phone)){
            $respone = array('data' => '', 'result' => '400', 'msg' => '手机号格式不正确');
            return json_encode($respone);
        }

        $old_data = Db::name('verify_code')->field('add_time, code')->where('phone',$phone)->order('id desc')->find();

        if ($old_data['add_time'] > time()) {
            $respone = array('data' => $old_data['code'], 'result' => '401', 'msg' => '手机验证码还未失效');
            return json_encode($respone);
        }

        $verify_code = mt_rand(1000,9999);
        $msg = '您的验证码为'.$verify_code.'，3分钟有效【千宜科技】';

        $respone = $this->run($phone, $msg);

        if ($respone['returnstatus'] === 'Success') {
            $save = ['phone' => $phone, 'code' => $verify_code, 'add_time' => time()+180];
            Db::name('verify_code')->insert($save);

            $respone = array('data' => $verify_code, 'result' => '200', 'msg' => '发送成功');
            return json_encode($respone);
        }

        $respone = array('data' => '', 'result' => '500', 'msg' => '验证码发送失败');
        return json_encode($respone);
    }
    
    /**
     * 希奥科技 - 及时通短信接口
     *
     * @param string $phone 发送对象手机号码
     * @param string $msg 要发送的内容
     * @return array
     */
    private static function run($phone='', $msg='')
    {
        if ($phone == '' || $msg == '') {
            return false;
        }

        $url = "http://dx.ipyy.net/smsJson.aspx"; // 接口地址
        $params = array(
            'userid' => "80078",
            'account' => "AE001234", // 账号
            'password' => "9caea1a07c5a161a96a9ac52c060fb04",//支付密码,md5加密
            'mobile' => $phone, // 手机号码，同时发送给多个号码，号码间用逗号分隔
            'content' => $msg,
            'action' => 'send'
        );

        $ch = curl_init();
        curl_setopt($ch,  CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);

        return json_decode($data, true);
    }
}