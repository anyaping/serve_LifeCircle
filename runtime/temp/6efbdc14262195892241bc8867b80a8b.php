<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:57:"E:\tp5.0\public/../application/admin\view\user\index.html";i:1510297546;}*/ ?>
<style type="text/css">
    .bar{
        color:#ddd;
    }
</style>
    <link href="__STYLE__admin/css/bootstrap.min.css" rel="stylesheet">
    <caption>用户管理</caption><br><br>
    <button type="button" class="btn btn-success sort">按余额排序</button>
    <table class="table">
        <thead>
            <tr>
                <th>编号</th>
                <th>头像</th>
                <th>昵称</th>
                <th>简介</th>
                <th>性别</th>
                <th>生日</th>
                <th>地址</th>
                <th>详细地址</th>
                <th>等级</th>
                <th>手机号</th>
                <th>邮箱</th>
                <th>账户余额</th>
                <th>注册时间</th>
            </tr>
        </thead>
        <tbody id="info">
                <?php if(is_array($results) || $results instanceof \think\Collection || $results instanceof \think\Paginator): $i = 0; $__LIST__ = $results;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr class="active">
                        <td><?php echo $vo['id']; ?></td>
                        <td><img width="50px" height="50px" src= "__LOGO__<?php echo $vo['img']; ?>"></td>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['abstract']; ?></td>
                        <td><?php echo $vo['sex']; ?></td>
                        <td><?php echo $vo['birthday']; ?></td>
                        <td><?php echo $vo['address1']; ?></td>
                        <td><?php echo $vo['address2']; ?></td>
                        <td><?php echo $vo['level']; ?></td>
                        <td><?php echo $vo['phone']; ?></td>
                        <td><?php echo $vo['email']; ?></td>
                        <td><?php echo $vo['money']; ?></td>
                        <td><?php echo date('Y-m-d',$vo['time']); ?></td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <script type="text/javascript" src="__STYLE__admin/js/jquery-3.2.0.min.js"></script>
    <script type="text/javascript" src="__STYLE__admin/js/layer.js"></script>

    <script type="text/javascript">
    //jquery的入口
    $(function(){

        //点击按余额排序
        $('.sort').click(function(){
            if ($(this).hasClass('bar')) {
                $(this).removeClass('bar')
                var sort = 'desc';
            }else{
                $(this).addClass('bar')
                var sort = 'asc';
            }

            $.ajax({
                url: "<?php echo url('user/sort'); ?>",    //请求地址
                data:{
                    sort:sort,
                },
                type:'post',
                dataType:'json',
                success:function(data){ //成功自动调用的回调函数
                    $('#info').html(data.html)
                },
                error:function(){
                    alert("ajax请求失败！");
                }
            });
        });


    });
</script>