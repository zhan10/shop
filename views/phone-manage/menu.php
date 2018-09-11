<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = '菜单管理';
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../adminJs/jqGrid/jquery.bootgrid.min.css" />
    <link rel="stylesheet" type="text/css" href="css/loaders.css">
    <style>
        .but{
            width: 50px;
            position: absolute;
            margin-top: 12px;
            z-index: 99;
        }
    </style>
</head>
<body>
<button type="button" class="btn btn-success btn-md but" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i>
</button>
<table id="grid-selection" class="table table-condensed table-hover table-striped">
    <thead>
    <tr>
        <th data-column-id="name" data-sortable="false" data-width="20%">菜单名称</th>
        <th data-column-id="url" data-sortable="false" data-width="20%">URl</th>
        <th data-column-id="login_status" data-formatter="login_status" data-sortable="false" data-width="20%">登陆状态</th>
        <th data-column-id="created_at" data-sortable="false" data-width="30%">创建时间</th>
        <th data-column-id="operation" data-formatter="operation" data-sortable="false">操作</th>
    </tr>
    </thead>
</table>
<!-- Modal -->
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">新增</h4>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <?php $form = ActiveForm::begin(['id'=>'menuForm','options' => ['enctype' => 'multipart/form-data']]) ?>
                <div class="box-body">
                    <div class="form-group">
                        <?= $form->field($menu, 'name')->textInput(['id'=>'name'])?>
                        <p id="nameError" style="color: red;display: none;">名称不能为空！</p>
                    </div>
                    <div class="form-group">
                        <?= $form->field($menu, 'url')->textInput(['id'=>'url'])?>
                    </div>
                    <div class="form-group" style="font-size: 12px;">
                        <?= $form->field($menu, 'login_status')->checkbox(['id'=>'login_status'])?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($menu, 'img')->fileInput(['id'=>'img','onchange'=>"Javascript:validate_img(this);",'class'=>'file','multiple' => true,'data-overwrite-initial'=>false]) ?>
                        <p id="imgError" style="color: red;display: none;">图标不能为空！</p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary menuSave">提交</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!--修改-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="editLoding" style="display:none;">
                <div class="loader">
                    <div class="loader-inner ball-pulse">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div id="editContent" style="display:none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">修改</h4>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <?php $form = ActiveForm::begin(['action'=>Url::to(['phone-manage/edit']),'id'=>'menuEditForm','options' => ['enctype' => 'multipart/form-data']]) ?>
                <div class="box-body">
                    <div class="form-group">
                        <input type="hidden" id="id" class="form-control" name="id">
                        <input type="hidden" id="delImg" class="form-control">
                        <?= $form->field($menu, 'name')->textInput(['id'=>'names'])?>
                        <p id="namesError" style="color: red;display: none;">名称不能为空！</p>
                    </div>
                    <div class="form-group">
                        <?= $form->field($menu, 'url')->textInput(['id'=>'urls'])?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($menu, 'login_status')->checkbox(['id'=>'login_statuss'])?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($menu, 'img')->fileInput(['id'=>'imgs','onchange'=>"Javascript:validate_img(this);",'class'=>'file','multiple' => true,'data-overwrite-initial'=>false]) ?>
                        <div><a id="icon" target="_blank"></a>&emsp;&emsp;<span class="fa fa-close" onclick="delImg(this)"></span></div>
                        <p id="imgsError" style="color: red;display: none;">Icon不能为空！</p>
                        <p id="imgssError" style="color: red;display: none;">Icon已存在请删除后添加.</p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary menuEdit">提交</button>
            </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
</body>

<script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.js"></script>
<script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.js"></script>
<script>
    function validate_img(a){
        var file = a.value;
        if(!/.(png)$/.test(file)){
            alert("图片类型必须是,png中的一种");
            $("#imgs").val("");
            $("#img").val("");
            return false;
        }else{
            var f = a.files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                var data = e.target.result;
                //加载图片获取图片真实宽度和高度
                var image = new Image();
                image.onload=function(){
                    var width = image.width;
                    var height = image.height;
                    if(width>256 && height>256 ){
                        alert('请上传256 * 256像素的图片');
                        $("#imgs").val("");
                        $("#img").val("");
                        return false;
                    }
                };
                image.src= data;
            };
            reader.readAsDataURL(f);
        }
    }
    $(".menuEdit").click(function(){
        var name = $("#names").val();
        var img = $("#imgs").val();
        var delImg = $("#delImg").val();
        if(name==""){
            $("#namesError").show();
        }else{
            $("#namesError").hide();
        }
        if(img==""&&delImg!=""){
            $("#imgsError").show();
        }else{
            $("#imgsError").hide();
        }
        if(delImg==""&&img!=""){
            $("#imgssError").show();
        }else{
            $("#imgssError").hide();
        }

        if((img!=""&&name!=""&&delImg==1)||(img==""&&name!=""&&delImg=="")){
            $("#menuEditForm").submit();
        }
    });
    $(".menuSave").click(function(){
        var name = $("#name").val();
        var img = $("#img").val();
        if(name==""){
            $("#nameError").show();
        }else{
            $("#nameError").hide();
        }
        if(img==""){
            $("#imgError").show();
        }else{
            $("#imgError").hide();
        }
        if(img!=""&&name!=""){
            $("#menuForm").submit();
        }
    });
    var grid = $("#grid-selection").bootgrid({
        ajax: true,
        url:"?r=phone-manage/menu-list",
        labels: {
            all: "全部",
            //表头左边显示提示信息
            infos: "显示{{ctx.start}}～{{ctx.end}}条， 总{{ctx.total}}条",
            loading: "加载中...",
            noResults: "没有相关数据",
            refresh: "刷新中...",
            search: "查询中..."
        },
        formatters: {
            "operation": function(column, row)
            {
                var str = "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\"></span></button> " +
                    "<button type=\"button\" class=\"btn btn-xs btn-default command-del\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-remove \"></span></button>";
                return str;
            },
            "login_status": function(column, row)
            {
                if(row.login_status==1){
                    return "需要登陆"
                }else{
                    return "不需要登陆"
                };
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
    {
        grid.find(".command-edit").on("click", function(e)
        {
            var id = $(this).data("row-id");
            $("#editModal").modal();
            $("#editLoding").show();
            find(id);
        }).end().find(".command-del").on("click", function(e)
        {
            var id = $(this).data("row-id");
            del(id);
            $(this).attr('disabled',true);
        })
    });
    function delImg(obj){
        $(obj).parent().remove();
        $("#delImg").val("1");
    }
    function find(id){
        $.ajax({
            "type": "POST", "success": function (data) {
                $("#editLoding").hide();
                $("#editContent").show();
                var json_Array = JSON.parse(data);
                $("#id").val(id);
                $("#names").val(json_Array.name);
                $("#urls").val(json_Array.url);
                if(json_Array.login_status==1){
                    $("#login_statuss").attr("checked",true);
                }
                $("#icon").attr('href',json_Array.img);
                $("#icon").html(json_Array.img.substring(json_Array.img.indexOf("/")+1));
            },
            "url":"?r=phone-manage/find-menu",
            "data":"id="+id
        });
    }
    function del(id){
        $.ajax({
            "type": "POST", "success": function (data) {
                if(data){
                    window.location.href="../web/index.php?r=phone-manage/menu-manage";
                }
            },
            "url":"?r=phone-manage/del-menu",
            "data":"id="+id
        });
    }
    $(function() {
        $('#myModal').on('hide.bs.modal',
            function() {
                var name = $("#name").val("");
                var img = $("#url").val("");
                var img = $("#img").val("");
            })
        $('#editModal').on('hide.bs.modal',
            function() {
                $("#editContent").hide();
                var name = $("#name").val("");
                var img = $("#url").val("");
                var img = $("#img").val("");
            })
    });
</script>
</html>

