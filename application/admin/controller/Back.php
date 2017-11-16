<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\render;
class Note extends controller
{
    /**
     * 初始化方法
     */
    public function _initialize(){
        $request = Request::instance();
        if(session('user')){
            $this->username = session('user')['username'];
            $this->assign('username',$this->username);
        }else{
            $controller = $request->controller();
            if($controller != 'Login'){
                return $this->redirect('Login/index');
            } 
        }
    }

    // /**
    //  * 加载反馈管理页面
    //  */
    // public function index(){

    //     $result = Db::table('lf_note')
    //             ->alias('n')
    //             ->join('lf_column c','n.note_columnid = c.id','LEFT')
    //             ->field('n.id,n.note_title,n.note_img,n.note_content,n.note_auth,c.column_name,n.note_time,n.note_status,n.note_stick,n.note_points')
    //             ->paginate(8);
    //     $page = $result->render();
    //     $this->assign('page',$page);
    //     $this->assign('results',$result);
    //     return $this->view->fetch();
    // }

    // /**
    //  * 点击添加弹出layer页面
    //  */
    // public function add(){
    //     $columns = Db::name('column')->field('id, column_name')->select();
    //     $this->assign('columns', $columns);
    //     return $this->view->fetch();
    // }

    // /**
    //  * 执行添加帖子
    //  */
    // public function doAdd(){
    //     $data = request()->post();
    //     $note_img = $this->upload();

    //     if(!$data){
    //         $respone = array('status' => 400, 'msg' => '请完善信息');
    //         return $respone;
    //         exit;
    //     }

    //     if ($note_img['status'] == 400) {
    //         return $note_img;
    //         exit;
    //     }

    //     $results = Db::name('column')->where('id',$data['note_column'])->find();

    //     $time = time();
    //     if($results){
    //         $data = array('note_title' => $data['note_title'], 'note_img' => $note_img['message'], 'note_content' => $data['note_content'], 'note_auth' => $data['note_auth'], 'note_columnid' => $data['note_column'], 'note_time' => $time);

    //         $result = Db::name('note')->insert($data);
    //         if($result){
    //             $respone = array('status' => 200, 'msg' => '添加成功');
    //         }else{
    //             $respone = array('status' => 400, 'msg' => '添加失败');
    //         }
    //     }else{
    //         $respone = array('status' => 400, 'msg' => '你所填的发帖栏目不存在');
    //     }
    //     return $respone;
    //     exit;
    // }


    // /**
    // *  点击修改弹出layer页面
    // */
    // public function edit(){
    //     $id = input('get.id');
    //     $result = Db::name('note')
    //             ->field('id,note_title,note_img,note_content,note_auth,note_columnid,note_time,note_status,note_stick,note_points')
    //             ->where('id',$id)
    //             ->find();

    //     $columns = Db::name('column')->field('id, column_name')->select();
    //     $this->assign('columns', $columns);
    //     $this->assign('results',$result);
    //     return $this->view->fetch();
    // }

    // /**
    //  * 执行修改帖子
    //  */
    // public function doedit(){
    //     $id = request()->post('note_id');
    //     $data = request()->post();
    //     $note_img = $this->upload();

    //     if(!$data){
    //         $respone = array('status' => 400, 'msg' => '请完善信息');
    //         return $respone;
    //         exit;
    //     }

    //     if ($note_img['status'] == 400) {
    //         return $note_img;
    //         exit;
    //     }
    //     $time = time();

    //     $results = Db::name('column')->where('id',$data['note_column'])->value('id');

    //     if($results){
    //         $old_logo = Db::name('note')->where('id',$id)->value('note_img');
    //         if($old_logo){
    //             unlink("upload/".$old_logo);
    //         }
    //         $result = Db::name('note')->where('id',$id)->update(['note_title'  => $data['note_title'],'note_img' => $note_img['message'],'note_content' => $data['note_content'],'note_auth' => $data['note_auth'],'note_columnid' => $results,'note_time' => $time,]);
    //         if($result){
    //             $respone = array('status' => 200, 'msg' => '修改成功');
    //         }else{
    //             $respone = array('status' => 400, 'msg' => '修改失败');
    //         }
    //     }else{
    //        $respone = array('status' => 400, 'msg' => '您所填写的栏目不存在'); 
    //     }
        
    //     return $respone;
    //     exit;
    // }

    

    // /**
    // *  执行删除
    // */
    // public function del(){
    //     $id = input('get.id');
    //     if(!$id){
    //         return $data = "id为空";
    //     }
    //     $result = Db::name('note')->where('id',$id)->delete();
    //     if($result){
    //         return $data = 1;
    //     }else{
    //         return $data = 0;
    //     }
    // }

    // /**
    // *  执行发布
    // */
    // public function release(){
    //     $id = input('get.id');
    //     $result = Db::name('note')->where('id',$id)->value('note_status');
    //     if($result == "0"){
    //         $results = Db::name('note')->where('id',$id)->update(['note_status' => '1']);
    //         return $data = 1;
    //     }else{
    //         return $data = -1;
    //     }
    // }

    // /**
    // *  帖子置顶
    // */
    // public function stick(){
    //     $id = input('get.id');
    //     $result = Db::name('note')->where('id',$id)->value('note_stick');
    //     if($result == "0"){
    //         $results = Db::name('note')->where('id',$id)->update(['note_stick' => '1']);
    //         return $data = 1;
    //     }else if($result == "1"){
    //         $results = Db::name('note')->where('id',$id)->update(['note_stick' => '0']);
    //         return $data = 0;
    //     }else{
    //         return $data = -1;
    //     }
    // }

    // /**
    // *  设置帖子领积分
    // */
    // public function points(){
    //     $id = input('get.id');
    //     $result = Db::name('note')->where('id',$id)->value('note_points');
    //     if($result == "0"){
    //         $results = Db::name('note')->where('id',$id)->update(['note_points' => '1']);
    //         return $data = 1;
    //     }else if($result == "1"){
    //         $results = Db::name('note')->where('id',$id)->update(['note_points' => '0']);
    //         return $data = 0;
    //     }else{
    //         return $data = -1;
    //     }
    // }

    // /**
    // *  点击已审核
    // */
    // public function yes(){
    //     $result = Db::table('lf_note')
    //             ->alias('n')
    //             ->join('lf_column c','n.note_columnid = c.id','LEFT')
    //             ->where('n.note_status', 1)
    //             ->field('n.id,n.note_title,n.note_img,n.note_content,n.note_auth,c.column_name,n.note_time,n.note_status,n.note_stick,n.note_points')
    //             ->paginate(8);
    //     $this->assign('results',$result);
    //     $respone['html'] = $this->view->fetch();
    //     return $respone;
    // }

    // /**
    // *  点击待审核
    // */
    // public function no(){
    //     $result = Db::table('lf_note')
    //             ->alias('n')
    //             ->join('lf_column c','n.note_columnid = c.id','LEFT')
    //             ->where('n.note_status', 0)
    //             ->field('n.id,n.note_title,n.note_img,n.note_content,n.note_auth,c.column_name,n.note_time,n.note_status,n.note_stick,n.note_points')
    //             ->paginate(8);
    //     $this->assign('results',$result);
    //     $respone['html'] = $this->view->fetch();
    //     return $respone;
    // }

    // /**
    // *  上传图片
    // */
    // public function upload(){
    //     $file = request()->file('note_img');
    //     // 移动到框架应用根目录/public/upload/ 目录下
    //     $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
    //     if($info){
    //         $respone['message'] = $info->getSaveName();
    //         $respone['status'] = 200;
    //         return $respone;
    //     }
    //     $respone['message'] = $info->getError();
    //     $respone['status'] = 400;
    //     return $respone;
    // }

}
