<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:58:"D:\tp5.0\public/../application/admin\view\login\index.html";i:1510279968;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title> - 登录</title>
    <link href="__STYLE__admin/css/bootstrap.min.css" rel="stylesheet">
</head>
<script type="text/javascript" src="__STYLE__admin/js/jquery-3.2.0.min.js"></script>
<script type="text/javascript" src="__STYLE__admin/js/layer.js"></script>

<body style="background-color:#ddd;">
    <div style="border:1px solid green;width:30%;height:405px;margin-top:10%;margin-left:35%;">
        <div style="height:350px">
            <div>
                <h4 style="color:black;margin-left:20px;">登录：</h4>
                <input style="margin-top:70px;margin-left:130px;" id="username" type="text" name="username" placeholder="请输入账号" /><br>
                <input style="margin-top:70px;margin-left:130px;" type="password" id="password" name="password" placeholder="请输入密码" />
                <button style="margin-top:100px;width:150px;margin-left:130px;" type="submit" id="login" class="btn btn-success btn-block">登录</button>
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    //jquery的入口
    $(function(){
        // 点击发布
        $("#login").click(function(){
            var username = $("#username").val();
            var password = $('#password').val();  
            $.ajax({
                url: "<?php echo url('login/dologin'); ?>",    //请求地址
                data:{
                    username:username,
                    password:password
                },
                type:"post",
                success:function(respone){ //成功自动调用的回调函数
                    if(respone.status === 200){
                        layer.alert(respone.msg);

                        setTimeout(function(){
                            window.location.href = '/admin/Index/index'
                        },1500)

                    }else if(respone.status === 400){

                        layer.alert(respone.msg);

                    }else{

                        layer.alert("请求超时！");
                    }
                },
                error:function(){

                    layer.alert("ajax请求失败！");

                }
            });
        });

    });
</script>