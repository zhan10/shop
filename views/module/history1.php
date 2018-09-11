<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
$this->title = '模块订购记录';
?>
<html>
<head>
    <link rel="stylesheet" href="../../css/style.css" type="text/css" media="all">
    <style>
        #ends{
            background-color: #0091db;
            border: 2px solid #0091db;
            color: #FFFFFF;
        }
        #ends a{
            color: #FFFFFF;
        }
        .a{
            color: black;
        }
        .box_news{font-size:14px;border: 1px solid #ccc;background-image: none;border-radius: 4px;height: 30px; padding: 6px 12px;line-height: 1.42857;width: 80px;}
        .clear_box {
            -moz-user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            font-size: 9px;
            font-weight: 400;
            line-height: 1.42857;
            margin-bottom: 5px;
            padding: 6px 12px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
    </style>
    <script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript">
        var inputss=new Array();
        $(document).ready(function(){
            $("tr").bind('click', function(){
                fss=$(this).children('td').eq(2).text();
            });
        });
        function inputs(){
            for(var i=0;i<=4;i++) {
                n=i+1;
                inputss[i]=document.getElementById('input'+n).value;
            }

            window.location.href="../web/index.php?r=module/find1&inputss="+inputss;
        }
        function so(){
            it=$("#ppp").val();
            it=it+' ASC';
            window.location.href="../web/index.php?r=module/manages1&it="+it;
        }
        function soo(){
            it=$("#ppp").val();
            it=it+' DESC';
            window.location.href="../web/index.php?r=module/manages1&it="+it;
        }
        function fs(){
            window.location.href="../web/index.php?r=message%2Findex&username="+fss;
        }
    </script>
</head>
<br>
<div>
    <ul class="navigation-bar navigation-bar-right">
        <li class="li" id="order" ><a href="index.php?r=module/history" class="a">订购记录</a></li>
        <li class="li" id="ends"><a href="index.php?r=module/history1" class="a">即将到期</a></li>
        <li class="li" id="end"><a href="index.php?r=module/history2" class="a">已到期</a></li>

    </ul>

</div>
<body class="hold-transition skin-blue sidebar-mini" >
<div style="width: 100%;height: 500px;background-color: white;margin-top: 37px;border: solid 1px" >
    <div style="margin-left: 15px;margin-top: 10px;">
        模块名称：<input id="input1" type="text" class="box_news">
        公司名称：<input id="input2" type="text" class="box_news">
        开通时间：<input id="input3" type="text" class="box_news" >
        到期时间：<input id="input4" type="text" class="box_news" >
        订单号：<input id="input5" type="text" class="box_news">
        <input type="button" onclick="inputs();" class="clear_box" value="查找">
        <select id="ppp" class="box_news"  style="width: 120px; margin-left: 20px;">
            <option value="title">模块名称</option>
            <option value="start_time">开通时间</option>
            <option value="end_time">到期时间</option>
            <option value="order_num">订单号</option>
            <option value="duration">开通时长</option>
        </select>
        <input type="button" onclick="so();" class="clear_box" value="顺序">
        <input type="button" onclick="soo();" class="clear_box" value="倒序">
    </div>
    <div class="box-body" >
        <table id="example2" class="table table-bordered table-hover" style="background-color: white" >
            <thead>
            <tr>
                <th>模块名称</th>
                <th>公司名称</th>
                <th>购买人</th>
                <th>手机号</th>
                <th>开通时间</th>
                <th>结束时间</th>
                <th>到期天数</th>
                <th>订单号</th>
                <th>价格</th>
                <th>通知</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($endOrders as $key => $value) : ?>
                <tr>
                    <td>
                        <?php echo $value->title;?>
                    </td>
                    <td><?php echo $value->corp;?></td>
                    <td>  <?php echo $value->username;?></td>
                    <td><?php echo $value->mobile;?></td>
                    <td><?php echo $value->start_time;?></td>
                    <td><?php echo $value->end_time;?></td>
                    <td><?php echo ceil((strtotime ($value->end_time)-strtotime (date("Y-m-d h:i:s")))/86400);?>天</td>
                    <td><?php echo $value->order_num;?></td>
                    <td><?php echo $value->total_price;?></td>
                    <td><a href="javascript:fs()">通知</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php echo  LinkPager::widget(['pagination' => $pages]); ?>
    </div>

</div>

</body>
</html>
