<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"E:\tp5.0\public/../application/admin\view\index\index.html";i:1510319792;s:58:"E:\tp5.0\public/../application/admin\view\common\head.html";i:1510022032;s:58:"E:\tp5.0\public/../application/admin\view\common\menu.html";i:1510298070;}*/ ?>
<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title> - 后台管理</title>
    <link href="__STYLE__admin/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    
    <style type="text/css">
      .nav{
        width: 100%;
        height: 50px;
        background-color: #ddd;
        float: left;
        line-height: 50px;
      }
    </style>
  <div class="nav">
    <span style="font-size:25px;margin-left:20px;">生活圈</span>
    <span style="float:right;margin-right:20px;">欢迎您登录后台！</span>
  </div>
    <script type="text/javascript" src="__STYLE__admin/js/jquery-3.2.0.min.js"></script>
<style type="text/css">
	.menu_left{
		float:left;
		width: 150px;
		height: 100%;
		background-color: #dfc;
	}
	ol{
		margin-top: 20px;
		margin-left: -20px;
		list-style: none;
	}
	.ol_li{
		height: 35px;
		width: 100%;
		line-height: 35px;
		color: blue;
		cursor: pointer;
	}
	ul{
		display: none;
	}
	ul li{
		margin-left: -10px;
		line-height: 35px;
		cursor: pointer;
	}
	.active{
		color: #ddd;
	}
	.bill{
		margin-top: 20px;
		font-size: 18px;
		font-weight: bold;
		text-align: center;
	}
</style>
<div class="menu_left">
	<div class="bill">菜单导航</div>
	<ol>
		<li class="ol_li">栏目管理</li>
			<ul>
				<li class="test" id="/admin/column/index" onclick="loadUrl(this.id)">栏目列表</li>
			</ul>
		<li class="ol_li">轮播图管理</li>
			<ul>
				<li class="test" id="/admin/carousel/index" onclick="loadUrl(this.id)">轮播图列表</li>
			</ul>
		<li class="ol_li">帖子管理</li>
			<ul>
				<li class="test" id="/admin/note/index" onclick="loadUrl(this.id)">帖子列表</li>
			</ul>
		<li class="ol_li">用户管理</li>
			<ul>
				<li class="test" id="/admin/user/index" onclick="loadUrl(this.id)">用户列表</li>
			</ul>
		<li class="ol_li">话题管理</li>
			<ul>
				<li class="test" id="/admin/topic/index" onclick="loadUrl(this.id)">话题列表</li>
			</ul>
	</ol>
</div>

<script type="text/javascript">
	$(function(){
		$('.ol_li').click(function(){
			console.log($(this))
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$(this).next('ul').hide(500);
				return;
			}

			$(this).siblings().removeClass('active');
			$(this).siblings().next('ul').hide(500);
			$(this).addClass('active');
			$(this).next('ul').show(500)
		})
	})
</script>
<div class="content" style="margin-left:160px;">
    <iframe id="J_iframe" width="100%" height="700px" src="/admin/index/home_page" scrolling="no" frameborder="0" seamless></iframe>
</div>
</body>
</html>
<script type="text/javascript" src="__STYLE__admin/js/jquery-3.2.0.min.js"></script>
<script type="text/javascript">
 
    //jquery的入口
    $(function(){

        // 点击删除
        $(".del").click(function(){
            var id = $(this).val();  
            $.pjax({
                url: "<?php echo url('Photo2/del'); ?>",    //请求地址
                data:{
                    id:id
                },
                type:"get",
                success:function(data){ //成功自动调用的回调函数
                    if(data == "1"){
                        alert("删除成功");
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

        // 点击添加
        $(".add").click(function(){
            layer.open({
                type: 2,
                area: ['600px', '360px'],
                shadeClose: true, //点击遮罩关闭
                content: "<?php echo url('Photo/select'); ?>",
            });
        });

        
    });
    function loadUrl(id){
        $("#J_iframe").attr('src',id);
        return false;
    }

</script>