<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"D:\tp5.0\public/../application/admin\view\twocolumn\add.html";i:1510541216;}*/ ?>
<link href="__STYLE__admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="__STYLE__admin/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="__STYLE__admin/js/jquery-3.2.0.min.js" type="text/javascript"></script>
<script src="__STYLE__admin/js/fileinput.min.js" type="text/javascript"></script>
<script src="__STYLE__admin/js/zh.js" type="text/javascript"></script>
<script type="text/javascript" src="__STYLE__admin/js/layer.js"></script>
<div class="container kv-main">
    <div class="page-header">
        <h2>二级栏目添加</h2>
    </div>
    <hr>
    <form enctype="multipart/form-data">
        <div class="form-group">
            <label for="column" class="col-sm-2 control-label">二级栏目名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="twocolumn_name" placeholder="请输入二级栏目名称">
            </div>
            <br><br>
            <label for="column" class="col-sm-2 control-label">上级栏目</label>
            <br><br>
                <select type="text" class="form-control" id="column">
                    <?php if(is_array($columns) || $columns instanceof \think\Collection || $columns instanceof \think\Paginator): $i = 0; $__LIST__ = $columns;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['column_name']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            <br><br>
            <input id="uploadfile" name="twocolumn_img" type="file" class="file" data-overwrite-initial="false" data-min-file-count="1">
        </div>
        <button type="button" id='doAdd' class="btn btn-success">提交</button>
    </form>
    <hr>
    <br>
</div>
<script type="text/javascript">
$("#uploadfile").fileinput({
    language: 'zh', //设置语言
    uploadUrl: "/admin/Twocolumn/doAdd", //上传的地址
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
                        var twocolumn_name = document.getElementById('twocolumn_name').value;
                        var column = document.getElementById('column');
                        var twocolumn_pid = column.options[column.selectedIndex].value;
                        return {"twocolumn_name": twocolumn_name,"twocolumn_pid": twocolumn_pid};
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

$('#doAdd').click(function(){
    twocolumn_img = $('#uploadfile').val()
    twocolumn_name = $('#twocolumn_name').val()
    twocolumn_pid = $('#column').val()

    if (!twocolumn_img || !twocolumn_name || !twocolumn_pid) {
        layer.msg('请完善信息！');
        return;
    }

    $("#uploadfile").fileinput('upload');   // 执行fileinput上传操作
})
</script>