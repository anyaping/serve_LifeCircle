<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:54:"D:\tp5.0\public/../application/admin\view\note\no.html";i:1510389022;}*/ ?>

                <?php if(is_array($results) || $results instanceof \think\Collection || $results instanceof \think\Paginator): $i = 0; $__LIST__ = $results;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr class="active">
                        <td><?php echo $vo['id']; ?></td>
                        <td><?php echo $vo['note_title']; ?></td>
                        <td><img width="50px" height="50px" src= "__LOGO__<?php echo $vo['note_img']; ?>"></td>
                        <td><?php echo $vo['note_content']; ?></td>
                        <td><?php echo $vo['note_auth']; ?></td>
                        <td><?php echo $vo['column_name']; ?></td>
                        <td><?php echo date('Y-m-d',$vo['note_time']); ?></td>
                        <td><?php if($vo['note_status'] == '1'): ?>审核通过<?php else: ?>待审核<?php endif; ?></td>
                        <td><?php if($vo['note_stick'] == '1'): ?>已置顶<?php else: ?>待置顶<?php endif; ?></td>
                        <td><?php if($vo['note_points'] == '1'): ?>领积分<?php else: ?>没有积分<?php endif; ?></td>
                        <td>
                            <button type="button" class="btn btn-danger del" value="<?php echo $vo['id']; ?>">删除</button>
                            <button type="button" class="btn btn-danger edit" value="<?php echo $vo['id']; ?>">修改</button>
                            <button type="button" class="btn btn-danger release" value="<?php echo $vo['id']; ?>">通过审核</button>
                            <button type="button" class="btn btn-danger stick" value="<?php echo $vo['id']; ?>">置顶</button>
                            <button type="button" class="btn btn-danger points" value="<?php echo $vo['id']; ?>">领积分</button>
                        </td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>

                                <script type="text/javascript" src="__STYLE__admin/js/jquery-3.2.0.min.js"></script>
    <script type="text/javascript" src="__STYLE__admin/js/layer.js"></script>

    <script type="text/javascript">
    //jquery的入口
    $(function(){

        //点击删除
        $('.del').click(function(){
            var id = $(this).val(); 
            $.ajax({
                url: "<?php echo url('note/del'); ?>",    //请求地址
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
                area: ['55%', '60%'], //宽高
                content: "edit?id="+id
            });
        });

        //点击通过审核
        $('.release').click(function(){
            var id = $(this).val(); 
            $.ajax({
                url: "<?php echo url('note/release'); ?>",    //请求地址
                data:{
                    id:id
                },
                type:"get",
                success:function(data){ //成功自动调用的回调函数
                    if(data == "1"){
                        alert("审核通过");
                        window.location.reload();
                    }else if(data == "-1"){
                        alert("设置失败");
                    }
                },
                error:function(){
                    alert("ajax请求失败！");
                }
            });
        });

        //点击置顶
        $('.stick').click(function(){
            var id = $(this).val(); 
            $.ajax({
                url: "<?php echo url('note/stick'); ?>",    //请求地址
                data:{
                    id:id
                },
                type:"get",
                success:function(data){ //成功自动调用的回调函数
                    if(data == "1"){
                        alert("置顶成功");
                        window.location.reload();
                    }else if(data == "0"){
                        alert("取消置顶成功");
                        window.location.reload();
                    }else if(data == "-1"){
                        alert("设置失败");
                    }
                },
                error:function(){
                    alert("ajax请求失败！");
                }
            });
        });

        //点击领积分
        $('.points').click(function(){
            var id = $(this).val(); 
            $.ajax({
                url: "<?php echo url('note/points'); ?>",    //请求地址
                data:{
                    id:id
                },
                type:"get",
                success:function(data){ //成功自动调用的回调函数
                    if(data == "1"){
                        alert("设置领积分成功");
                        window.location.reload();
                    }else if(data == "0"){
                        alert("取消领积分成功");
                        window.location.reload();
                    }else if(data == "-1"){
                        alert("设置失败");
                    }
                },
                error:function(){
                    alert("ajax请求失败！");
                }
            });
        });


    });
</script>