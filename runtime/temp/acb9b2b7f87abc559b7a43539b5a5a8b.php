<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"D:\tp5.0\public/../application/admin\view\twocolumn\index.html";i:1510545119;}*/ ?>

    <link href="__STYLE__admin/css/bootstrap.min.css" rel="stylesheet">
    <caption>二级栏目管理</caption><br><br>
    <button type="button" class="btn btn-success add">添加二级栏目</button>
    <table class="table">
        <thead>
            <tr>
                <th>编号</th>
                <th>图片</th>
                <th>二级栏目名称</th>
                <th>上级栏目名称</th>
                <th colspan="2">操作</th>
            </tr>
        </thead>
        <tbody>
                <?php if(is_array($results) || $results instanceof \think\Collection || $results instanceof \think\Paginator): $i = 0; $__LIST__ = $results;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr class="active">
                        <td><?php echo $vo['id']; ?></td>
                        <td><img width="50px" height="50px" src= "__LOGO__<?php echo $vo['twocolumn_img']; ?>"></td>
                        <td><?php echo $vo['twocolumn_name']; ?></td>
                        <td><?php echo $vo['leader_name']; ?></td>
                        <td>
                            <button type="button" class="btn btn-danger del" value="<?php echo $vo['id']; ?>">删除</button>
                            <button type="button" class="btn btn-danger edit" value="<?php echo $vo['id']; ?>">修改</button>
                        </td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <?php echo $page; ?>
    <script type="text/javascript" src="__STYLE__admin/js/jquery-3.2.0.min.js"></script>
    <script type="text/javascript" src="__STYLE__admin/js/layer.js"></script>

    <script type="text/javascript">
    //jquery的入口
    $(function(){
        // 点击发布
        $(".add").click(function(){
            layer.open({
              type: 2,
              skin: 'layui-layer-rim', //加上边框
              area: ['620px', '440px'], //宽高
              content: 'add'
            });
         
        });

        //点击删除
        $('.del').click(function(){
            var id = $(this).val(); 
            $.ajax({
                url: "<?php echo url('twocolumn/del'); ?>",    //请求地址
                data:{
                    id:id
                },
                type:"get",
                success:function(data){ //成功自动调用的回调函数
                    if(data == "1"){
                        alert("删除成功");
                        window.location.reload();
                    }else if(data == "0"){
                        alert("删除失败");
                    }else if(data == "id为空"){
                        alert("id为空");
                    }
                },
                error:function(){
                    alert("ajax请求失败！");
                }
            });
        });

        //点击修改
        $('.edit').click(function(){
            var id = $(this).attr('value')
            layer.open({
                type: 2,
                skin: 'layui-layer-rim', //加上边框
                area: ['65%', '70%'], //宽高
                content: "edit?id="+id
            });
        });


    });
</script>