<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '授权记录';
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../adminJs/jqGrid/jquery.bootgrid.min.css" />
</head>
<body>
    <table id="grid-selection" class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th data-column-id="BuildingName" data-sortable="false" data-width="25%">楼栋</th>
            <th data-column-id="DoorTitle" data-sortable="false" data-width="25%">门名称</th>
            <th data-column-id="UserName" data-sortable="false" data-width="25%">访客</th>
            <th data-column-id="Operationer" data-sortable="false" data-width="25%">授权人</th>
            <th data-column-id="StartDate" data-sortable="false" data-width="25%">有效时间</th>
            <th data-column-id="EndDate" data-sortable="false" data-width="25%">结束时间</th>
        </tr>
        </thead>
    </table>
</body>
<script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.js"></script>
<script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.js"></script>
<script>
    var grid = $("#grid-selection").bootgrid({
        ajax: true,
        url:"?r=authorise-record/get-list",
        labels: {
            all: "全部",
            //表头左边显示提示信息
            infos: "显示{{ctx.start}}～{{ctx.end}}条， 总{{ctx.total}}条",
            loading: "加载中...",
            noResults: "没有相关数据",
            refresh: "刷新中...",
            search: "查询中..."
        },
    });
</script>
</html>

