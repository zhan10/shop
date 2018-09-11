<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '公司管理';
?>
<html>
<head>
<script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    var datas=0;
    var fss='';
    var inputss=new Array();
    $(document).ready(function(){
        $("tr").bind('click', function(){
            datas=$(this).children('td').eq(0).text();
            fss=$(this).children('td').eq(6).text();
        });
    });

    function showDivFun(){
        window.location.href="../web/index.php?r=management%2Fmanages&datas="+datas;
    };

    function inputs(){
        for(var i=0;i<=4;i++) {
            n=i+1;
            inputss[i]=document.getElementById('input'+n).value;
        }
        window.location.href="../web/index.php?r=management%2Fmanagess&inputss="+inputss;
    };
    function so(){
        it=$("#ppp").val();
        if(it=='公司'){
           it='corp';
        }else if(it=='管理员')
        {
            it='username';
        }else if(it=='消费总额')
        {
            it='expendamount';
        }else if(it=='手机号码')
        {
            it='mobile';
        }else if(it=='员工数量')
        {
            it='employees_number';
        }
        it=it+' ASC';
        window.location.href="../web/index.php?r=management%2Fmanagesss&it="+it;
    }
    function soo(){
        it=$("#ppp").val();
        if(it=='公司'){
            it='corp';
        }else if(it=='管理员')
        {
            it='username';
        }else if(it=='消费总额')
        {
            it='expendamount';
        }else if(it=='手机号码')
        {
            it='mobile';
        }else if(it=='员工数量')
        {
            it='employees_number';
        }
        it=it+' DESC';
        window.location.href="../web/index.php?r=management%2Fmanagesss&it="+it;
    }
    function fs(){
        window.location.href="../web/index.php?r=message%2Findex&username="+fss;
    }
</script>
<style>
    #bg{ position: absolute; top: 0%; left: 0%;width: 100%;height: 100%; background-color: black; z-index:1001; -moz-opacity: 0.7; opacity:.70; filter: alpha(opacity=70);}
    #ss{position: absolute; top: 40%; left: 40%;  padding: 8px; background-color: white; z-index:1002; overflow: auto;}
    #ss{background-color:#EAEAEA; width:1040px; height: 420px; position:fixed;left:20%;top:25%}
    #xx { background-color:#EAEAEA; width:1025px; height: 350px;margin-left:0.5% };
</style>
</head>
<body>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div style="margin-left: 15px;margin-top: 10px;">
                    公司：<input id="input1" type="text" style="width: 100px">
                    域名：<input id="input2" type="text" style="width: 100px">
                    管理员：<input id="input3" type="text" style="width: 100px">
                    手机号码：<input id="input4" type="text" style="width: 100px">
                    email：<input id="input5" type="text" style="width: 100px">
                    <input type="button" onclick="inputs();" value="查找">
                    <select id="ppp" style="width: 100px; margin-left: 20px;">
                        <option>公司</option>
                        <option>管理员</option>
                        <option>消费总额</option>
                        <option>手机号码</option>
                        <option>员工数量</option>
                    </select>
                    <input type="button" onclick="so();" value="顺序">
                    <input type="button" onclick="soo();" value="倒序">
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x:auto;">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                        <tr id="sm">
                            <th>公司</th>
                            <th>域名</th>
                            <th>消费总额</th>
                            <th>管理员</th>
                            <th>操作</th>
                            <th>手机号码</th>
                            <th>email</th>
                            <th>创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($management as $resource){?>
                            <tr>
                                <td><?= Html::encode($resource->corp)?></td>
                                <td><?= Html::encode($resource->domain) ?></td>
                                <td><a href="javascript:showDivFun()"><?= Html::encode($resource->expendamount) ?></a></td>
                                <td><?= Html::encode($resource->username) ?></td>
                                <td><a href="javascript:fs()">发送消息</a></td>
                                <td><?= Html::encode($resource->mobile) ?></td>
                                <td><?= Html::encode($resource->email) ?></td>
                                <td><?= Html::encode($resource->created_at) ?></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <?php echo  LinkPager::widget(['pagination' => $pages]); ?>
                </div>
                <?php if ($query1!=null) : ?>
                    <div id="bg"></div>
                    <div id="ss">
                    <div id="xx" class="box-body" style="display:block;overflow-y:auto;">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>corp</th>
                                <th>module_id</th>
                                <th>order_num</th>
                                <th>total_price</th>
                                <th>duration</th>
                                <th>start_time</th>
                                <th>end_time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($query1 as $yy){?>
                                <tr>
                                    <td><?= $yy['corp']?></td>
                                    <td><?= $yy['module_id']?></td>
                                    <td><?= $yy['order_num']?></td>
                                    <td><?= $yy['total_price']?></td>
                                    <td><?= $yy['duration']?></td>
                                    <td><?= $yy['start_time']?></td>
                                    <td><?= $yy['end_time']?></td>
                                </tr>
                                <?php }?>
                            <tr>

                            </tr>
                            </tbody>
                        </table>
                        </div>
                        <div style="width:20px;height:20px;background-color:Black;margin-left: 90%; padding-bottom: 2%;">
                        <input type="button" value="关闭"  onclick="javascript:history.go(-1);" >
                        </div>
                    </div>
                <?php endif; ?>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
</body>
</html>
