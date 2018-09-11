<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = '角色管理';
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../adminJs/jqGrid/jquery.bootgrid.min.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
    <!--<button type="button" class="btn btn-success btn-md but" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-plus"></i>
    </button>-->
    <table id="grid-selection" class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th data-column-id="id" data-width="50" data-order="asc" data-type="numeric" data-sortable="false" data-identifier="true" data-visible="false">ID</th>
            <th data-column-id="name" data-sortable="false" data-width="40%">角色名称</th>
            <th data-column-id="created_at" data-sortable="false" data-width="40%">创建时间</th>
            <th data-column-id="operation" data-formatter="operation" data-sortable="false">操作</th>
        </tr>
        </thead>
    </table>
    <!-- 新增Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">新增</h4>
                </div>
                <div class="modal-body">
                    <!-- form start -->
                    <?php $form = ActiveForm::begin(['id'=>'roleForm']) ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?= $form->field($role, 'name')->textInput()?>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <!-- 修改Modal -->
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
                    <form id="menuForm" action="<?=Url::to(['phone-manage/menu-save']);?>" method="post">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label">角色名称</label>
                                <input type="text" readonly="readonly" id="roleName" class="form-control" name="name">
                                <input type="hidden" id="roleId" class="form-control" name="roleId">
                                <input type="hidden" id="menus" class="form-control" name="menus">
                                <div class="help-block"></div>
                            </div>
                        </div>
                        <label class="control-label">菜单分配</label>
                        <div class="container">
                            <ul class="data-list" id="lList">
                                <h4>为选中</h4>
                            </ul>
                            <div class="button-box">
                                <span id="add"></span>
                                <span id="remove"></span>
                            </div>
                            <ul class="data-list" id="rList">
                                <h4>已选中</h4>
                            </ul>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary editSave">提交</button>
                    </div>
                </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</body>

<script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.js"></script>
<script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.js"></script>
<script src="js/Deleteselected.js"></script>
<script>
    $(".editSave").click(function(){
        var ids = "";
        var elect = $("#rList li");
        for(var i=0;i<elect.length;i++){
            ids += elect.eq(i).attr("value")+",";
        }
        ids = ids.substr(0,ids.length-1);
        $("#menus").val(ids);
        $("#menuForm").submit();
    });
    var grid = $("#grid-selection").bootgrid({
        ajax: true,
        url:"?r=phone-manage/role-list",
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
                var str = "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\"></span></button>";
                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
    {
        grid.find(".command-edit").on("click", function(e)
        {
            var id = $(this).data("row-id");
            findRecord(id);
            $("#editModal").modal();
            $("#editLoding").show();
        })
    });
    //按升序排列
    function up(x,y){
        return x.value-y.value
    }
    function findRecord(id){
        $.ajax({
            "type": "POST", "success": function (data) {
                debugger;
                var json_Array = JSON.parse(data);
                $('#roleName').val(json_Array.roleName);
                $('#roleId').val(id);
               /* for(var i=0;i<json_Array.notElectMenu.length;i++){
                    $("#lList").append("<li value='"+json_Array.notElectMenu[i].id+"'>"+json_Array.notElectMenu[i].name+"</li>")
                }*/
                for (var index in json_Array.notElectMenu) {
                    $("#lList").append("<li value='"+json_Array.notElectMenu[index].id+"'>"+json_Array.notElectMenu[index].name+"</li>")
                }
                for(var i=0;i<json_Array.electMenu.length;i++){
                    $("#rList").append("<li value='"+json_Array.electMenu[i].id+"'>"+json_Array.electMenu[i].name+"</li>")
                }
                $("#editLoding").hide();
                $("#editContent").show();
                menuAssignment();
            },
            "url":"?r=phone-manage/find-by-id",
            "data":"id="+id
        });
    }
    $(function() {
        $('#editModal').on('hide.bs.modal',
            function() {
                $("#editContent").hide();
                $("#lList li").remove();
                $("#rList li").remove();
            })
    });

</script>
</html>

