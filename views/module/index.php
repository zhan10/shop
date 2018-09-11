<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
    $this->title = '模块管理';

?>
<html>
    <head>
        <link rel="stylesheet" href="../../css/style.css" type="text/css" media="all">
        <script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script type="text/javascript">

            function showDivFun(module_id,title,base_price){
                var allBox = document.getElementsByClassName(module_id);
                document.getElementById("bg").style.display ="block";
                document.getElementById('xxsss').style.display='block';
                document.getElementById('ids').value =module_id;
                document.getElementById('name').value =title;
                document.getElementById('state').value ="收费";
                document.getElementById('base_price').value =base_price;
                document.getElementById('rate1').value =allBox[0].innerHTML.trim();
                document.getElementById('rate2').value =allBox[1].innerHTML.trim();
                document.getElementById('rate3').value =allBox[2].innerHTML.trim();
                document.getElementById('buy_num').innerHTML =allBox[3].innerHTML.trim();
                document.getElementById('total_price').innerHTML =allBox[4].innerHTML.trim();
            };
            $(document).ready(function(){

                $(".title img").click(function(){
                    document.getElementById("bg").style.display ='none';
                    $(this).parent().parent().parent().hide("slow");
                });
                $("#close").click(function(){
                    document.getElementById("bg").style.display ='none';
                    $("#xxsss").hide();
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

    <div style="padding-left: 90%;padding-bottom: 10px">
        <a href="?r=module/index"><input type="button" value="图标" ></a>
        <a href="?r=module/list"><input type="button" value="列表"></a>
    </div>

    <body class="hold-transition skin-blue sidebar-mini">

    <div class="window" id="center">

        <div class="row">


            <?php foreach ($baseModule as $key => $value) : ?>

                <?php if ($value->state==0 ): ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box" >
                            <span class="info-box-icon " style="background-color: white"><img src="../../img/<?php echo trim(strtolower($value->module_id)); ?>.png" style="width: 90px;height: 90px;margin-bottom: 12px;" /></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><strong> <?php echo  $value->title; ?></strong></span>
                                </div>
                                </div>
                            </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
        <br>
        <div class="row">
            <?php foreach ($baseModule as $key => $value) : ?>

                <?php if ($value->state==1 ): ?>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box" >
                            <span class="info-box-icon " style="background-color: white"><img src="../../img/<?php echo trim(strtolower($value->module_id)); ?>.png" style="width: 90px;height: 90px;margin-bottom: 12px;" /></span>

                            <div class="info-box-content">
                                <span  style="display: none" class="<?php echo trim(strtolower($value->module_id)); ?>">
                                    <?php foreach ($rate as $k => $v) : ?>
                                        <?php $objs = (object)$v; ?>
                                        <?php if (trim($value->id)==trim($objs->base_id) && $objs->duration_id==2 ): ?>
                                            <?php echo ($objs->rate)*100;?>
                                            <?php break;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </span>
                                  <span  style="display: none" class="<?php echo trim(strtolower($value->module_id)); ?>">
                                    <?php foreach ($rate as $k => $v) : ?>
                                        <?php $objs = (object)$v; ?>
                                        <?php if (trim($value->id)==trim($objs->base_id) && $objs->duration_id==3 ): ?>
                                            <?php echo ($objs->rate)*100;?>
                                            <?php break;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </span>
                                 <span  style="display: none" class="<?php echo trim(strtolower($value->module_id)); ?>">
                                    <?php foreach ($rate as $k => $v) : ?>
                                        <?php $objs = (object)$v; ?>
                                        <?php if (trim($value->id)==trim($objs->base_id) && $objs->duration_id==4 ): ?>
                                            <?php echo ($objs->rate)*100;?>
                                            <?php break;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </span>
                                <span  style="display: none" class="<?php echo trim(strtolower($value->module_id)); ?>">
                                   <?php foreach ($arr as $k => $v) : ?>
                                       <?php $objs = (object)$v; ?>
                                       <?php if (trim(strtolower($objs->module_id))==trim(strtolower($value->module_id))): ?>
                                           <?php echo $objs->count; ?>
                                           <?php break;?>
                                       <?php endif; ?>
                                   <?php endforeach; ?>
                                </span>
                                  <span  style="display: none" class="<?php echo trim(strtolower($value->module_id)); ?>">
                                    <?php foreach ($sum_price as $k => $v) : ?>
                                        <?php $objs = (object)$v; ?>
                                        <?php if (trim(strtolower($objs->module_id))==trim(strtolower($value->module_id))): ?>
                                            <?php echo round($objs->total,2); ?>
                                            <?php break;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </span>


                                <span  style="display: none"><strong> <?php echo  $value->module_id; ?></strong></span>
                                <span class="info-box-text"><strong> <?php echo  $value->title; ?></strong></span>
                                <br>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%;background-color: black"></div>
                                </div>

                          <span class="progress-description" >
                           <a herf="" id="as" onclick="showDivFun('<?php echo trim(strtolower($value->module_id)); ?>','<?php echo trim(strtolower($value->title)); ?>','<?php echo trim(strtolower($value->base_price)); ?>')">价格设置</a>
                          </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    </body>


</html>
<div id="bg" ></div>
<div id="xxsss" style="display: none">
    <div class="window" id="center">
        <div id="title" class="title"><img src="../../img/1.jpg" alt="关闭" />模块管理—修改</div>
        <div class="contents">

            <?php $form = ActiveForm::begin(['action' => '?r=module/save1', ]); ?>

            <input type="text" id="ids" style="display: none" name="ids">
            <strong>模块名称：</strong><input type="text" class="inp" id="name" name="name"  disabled="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>模块状态：</strong><input type="text" class="inp" id="state" name="state" disabled="true"><br><br>
            <strong>单月价格：</strong><input type="text" class="inp" id="base_price" name="base_price" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>季度折扣：</strong><input type="text" class="inp" id="rate1" name="rate1">%<br><br>
            <strong>半年折扣：</strong><input type="text" class="inp" id="rate2" name="rate2">%&nbsp;&nbsp;&nbsp;
            <strong>年度折扣：</strong><input type="text" class="inp" id="rate3" name="rate3">%<br><br>
            <strong>购买次数：<label id="buy_num" style="width: 162px;" ></label></strong>&nbsp;&nbsp;
            <strong>总价：<label id="total_price" style="width: 100px;" ></label></strong><br><br>
            <div class="box-footer" style="text-align: center" >
                <button type="submit" class="btn btn-info" id="form">保存</button>
                <button type="button" class="btn btn-info " id="close">关闭</button>
            </div>


            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>