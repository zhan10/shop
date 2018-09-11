<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
$this->title = '模块管理';
?>
<html>
<head>
    <link rel="stylesheet" href="../../css/style.css" type="text/css" media="all">
    <style type="text/css">
        .window{  width:500px;  background-color:#d0def0;  position:absolute;  padding:2px;  margin:5px;  display:none; z-index:1002; overflow: auto; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript">
        //获取窗口的高度
        var windowHeight;
        //获取窗口的宽度
        var windowWidth;
        //获取弹窗的宽度
        var popWidth;
        //获取弹窗高度
        var popHeight;
        function init(){
            windowHeight=$(window).height();
            windowWidth=$(window).width();
            popHeight=$(".window").height();
            popWidth=$(".window").width();
        }
        $(document).ready(function(){


            $("tr").bind('dblclick', function(){
                var arr=[];
                $($(this).children('td')).each(function(){
                    arr.push($(this).text());
                });
                $("#ids").val(arr[0]);
                $("#name").val(arr[1]);
                $("#state").val(arr[2]);
                $("#base_price").val(arr[3]);
                $("#rate1").val($.trim(arr[4]));
                $("#rate2").val($.trim(arr[5]));
                $("#rate3").val($.trim(arr[6]));
                $("#buy_num").html($.trim(arr[7]));
                $("#total_price").html($.trim(arr[8]));
                if(arr[2]=="免费"){
                    $('#base_price').attr("disabled","disabled");
                    $('#rate1').attr("disabled","disabled");
                    $('#rate2').attr("disabled","disabled");
                    $('#rate3').attr("disabled","disabled");
                }else{
                    $('#base_price').attr("disabled",false);
                    $('#rate1').attr("disabled",false);
                    $('#rate2').attr("disabled",false);
                    $('#rate3').attr("disabled",false);
                }

                init();
                document.getElementById("bg").style.display ="block";
                $(this).parent().parent().show("slow");
                //计算弹出窗口的左上角Y的偏移量
                var popY=(windowHeight-popHeight)/2;
                var popX=(windowWidth-popWidth)/2;
                //设定窗口的位置
                $("#center").css("top",popY).css("left",popX).slideToggle("slow");

            });
            //关闭窗口
            $(".title img").click(function(){
                document.getElementById("bg").style.display ='none';
                $(this).parent().parent().hide("slow");
            });
            $("#close").click(function(){
                document.getElementById("bg").style.display ='none';
                $(this).parent().parent().parent().parent().hide("slow");
            });
            var reg=/^([1-9]\d?|100)$/;
            var reg1=/^\+?[1-9][0-9]*$/;
            $("#form").click(function(){
                if(!reg.test($("#rate1").val() || $("#rate1").val()=="") ){
                    alert("折扣格式不正确，请输入1-100的整数！");
                    return false;
                }
                if(!reg.test($("#rate2").val() || $("#rate2").val()=="") ){
                    alert("折扣格式不正确，请输入1-100的整数！");
                    return false;
                }
                if(!reg.test($("#rate3").val() || $("#rate3").val()=="") ){
                    alert("折扣格式不正确，请输入1-100的整数！");
                    return false;
                }
                if(!reg1.test($("#base_price").val() || $("#base_price").val()=="") ){
                    alert("单月价格格式不正确，请输入整数！");
                    return false;
                }
            });
        });

    </script>
</head>
<div style="padding-left: 90%">
    <a href="?r=module/index"><input type="button" value="图标" id="btn"></a>
    <a href="?r=module/list"><input type="button" value="列表" id="list"></a>
</div>

<body class="hold-transition skin-blue sidebar-mini">
<div id="bg" ></div>
<div class="window" id="center">
    <div id="title" class="title"><img src="../../img/1.jpg" alt="关闭" />模块管理—修改</div>
    <div class="contents">

        <?php $form = ActiveForm::begin(['action' => '?r=module/save' ]); ?>

        <input type="text" id="ids" style="display: none" name="ids">
        <strong>模块名称：</strong><input type="text" class="inp" id="name" name="name" disabled="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>模块状态：</strong><input type="text" class="inp" id="state" name="state" disabled="true"><br><br>
        <strong>单月价格：</strong><input type="text" class="inp" id="base_price" name="base_price" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>季度折扣：</strong><input type="text" class="inp" id="rate1" name="rate1">%<br><br>
        <strong>半年折扣：</strong><input type="text" class="inp" id="rate2" name="rate2">%&nbsp;&nbsp;
        <strong>年度折扣：</strong><input type="text" class="inp" id="rate3" name="rate3">%<br><br>
        <strong>购买次数：<label id="buy_num" style="width: 162px;" ></label></strong>&nbsp;&nbsp;
        <strong>总价：<label id="total_price" style="width: 100px;" ></label></strong><br><br>
        <div class="box-footer" style="text-align: center" >
            <button type="submit" class="btn btn-info" id="form" >保存</button>
            <button type="button" class="btn btn-info " id="close">关闭</button>
        </div>


        <?php ActiveForm::end(); ?>

    </div>
</div>

    <div class="box-body" style="overflow-x:auto;">

        <table id="example2" class="table table-bordered table-hover"  >
            <thead>
            <tr>
                <th>ID</th>
                <th>模块名称</th>
                <th>模块状态</th>
                <th>单月价格</th>
                <th>季度折扣</th>
                <th>半年折扣</th>
                <th>年度折扣</th>
                <th>购买次数</th>
                <th>总价</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($baseModule as $key => $value) : ?>
                <tr>
                    <td><?php echo $value->id;?></td>
                    <td><?php echo $value->title;?></td>
                    <td><?php echo ($value->state)==1? '收费' : '免费';?></td>
                    <td><?php echo $value->base_price;?></td>
                    <td>
                        <?php foreach ($rate as $k => $v) : ?>
                            <?php $objs = (object)$v; ?>
                            <?php if (trim($value->id)==trim($objs->base_id) && $objs->duration_id==2 ): ?>
                                <?php echo $objs->rate*100;?>
                                <?php break;?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($rate as $k => $v) : ?>
                            <?php $objs = (object)$v; ?>
                            <?php if (trim($value->id)==trim($objs->base_id) && $objs->duration_id==3 ): ?>
                                <?php echo $objs->rate*100;?>
                                <?php break;?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($rate as $k => $v) : ?>
                            <?php $objs = (object)$v; ?>
                            <?php if (trim($value->id)==trim($objs->base_id) && $objs->duration_id==4 ): ?>
                                <?php echo $objs->rate*100;?>
                                <?php break;?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($arr as $k => $v) : ?>
                            <?php $objs = (object)$v; ?>
                            <?php if (trim(strtolower($objs->module_id))==trim(strtolower($value->module_id))): ?>
                                <?php echo $objs->count; ?>
                                <?php break;?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($sum_price as $k => $v) : ?>
                            <?php $objs = (object)$v; ?>
                            <?php if (trim(strtolower($objs->module_id))==trim(strtolower($value->module_id))): ?>
                                <?php echo round($objs->total,2); ?>
                                <?php break;?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php echo  LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</body>
</html>














