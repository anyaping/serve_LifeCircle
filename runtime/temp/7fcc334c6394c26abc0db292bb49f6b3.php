<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:57:"E:\tp5.0\public/../application/admin\view\index\edit.html";i:1510069275;}*/ ?>
<link href="__STYLE__admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="__STYLE__admin/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="__STYLE__admin/js/jquery-3.2.0.min.js" type="text/javascript"></script>
<script src="__STYLE__admin/js/fileinput.min.js" type="text/javascript"></script>
<script src="__STYLE__admin/js/zh.js" type="text/javascript"></script>
<script type="text/javascript" src="__STYLE__admin/js/layer.js"></script>
<div class="container kv-main">
    <div class="page-header">
        <h2>栏目修改</h2>
    </div>
    <hr>
	<form enctype="multipart/form-data">
		<table style="margin-left:100px;margin-top:30px;">
			<tr style="height:80px;">
				<td>栏目名称</td>
				<td>
					<div style="text-align:center;">
						<input type="hidden" name="id" id="column_id" value="<?php echo $results['id']; ?>">
						<input style="margin-left:120px;margin-top:-5px;text-align:center;" type="text" id="column" name="column" value="<?php echo $results['column_name']; ?>">
					</div>
				</td>
			</tr>
			<tr style="height:80px;">
				<td>图片</td>
				<td>
					<div style="text-align:center;">
						<input style="margin-left:120px;margin-top:-5px;text-align:center;" type="file" id="uploadfile" name="column_logo" value="<?php echo $results['column_logo']; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<input style="margin-top:60px;margin-left:40px;" class="btn btn-default yes" type="button" value="提交">
				</td>
			</tr>
		</table>
	</form>
<hr>
    <br>
</div>
<script type="text/javascript">
$("#uploadfile").fileinput({
    language: 'zh', //设置语言
    uploadUrl: "/admin/Column/doedit", //上传的地址
    allowedFileExtensions: ['jpg', 'gif', 'png', 'jpeg'],//接收的文件后缀
    uploadAsync: true, //默认异步上传
    showUpload: false, //是否显示上传按钮
    showRemove : true, //显示移除按钮
    showPreview : true, //是否显示预览
    showCaption: true,//是否显示标题
    browseClass: "btn btn-primary", //按钮样式     
    dropZoneEnabled: false,//是否显示拖拽区域
    //minImageWidth: 50, //图片的最小宽度
    //minImageHeight: 50,//图片的最小高度
    //maxImageWidth: 1000,//图片的最大宽度
    //maxImageHeight: 1000,//图片的最大高度
    maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
    //minFileCount: 0,
    maxFileCount: 100, //表示允许同时上传的最大文件个数
    enctype: 'multipart/form-data',
    validateInitialCount:true,
    previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
    msgFilesTooMany: "选择上传的文件数量({n}) 超过允许的最大数值{m}！",
    uploadExtraData: function() {
                        var column_name = document.getElementById('column').value;
                        var id = document.getElementById('column_id').value;
                        return {"column_name": column_name, 'id': id};
                    }
});

//异步上传返回结果处理
$("#uploadfile").on("fileuploaded", function (event, data, previewId, index) {
    var obj = data.response;
    layer.msg(obj.msg, {icon: 6});

    setTimeout(function(){
            parent.window.location.reload();
            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
            parent.layer.close(index);
        },1000);
});

$('.yes').click(function(){
    column_logo = $('#uploadfile').val()
    column_name = $('#column').val()

    if (!column_name || !column_logo) {
        layer.msg('请完善信息！');
        return;
    }

    $("#uploadfile").fileinput('upload');   // 执行fileinput上传操作
})
</script>