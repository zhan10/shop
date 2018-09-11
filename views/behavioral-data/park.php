<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '停车分析';
?>
<link rel="stylesheet" type="text/css" href="../../adminJs/jqGrid/jquery.bootgrid.min.css" />
<table id="grid-selection" class="table table-condensed table-hover table-striped">
    <thead>
    <tr>
        <th data-column-id="name" data-sortable="false" data-width="30%">公司名称</th>
        <th data-column-id="number" data-sortable="false" data-width="30%">使用人数</th>
        <th data-column-id="ratio" data-formatter="ratio" data-sortable="false" data-width="30%">使用占比</th>
    </tr>
    </thead>
</table>
<script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.js"></script>
<script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.js"></script>
<script>
    var grid = $("#grid-selection").bootgrid({
        ajax: true,
        url:"?r=behavioral-data/get-park-list",
        labels: {
            all: "全部",
            //表头左边显示提示信息
            infos: "显示{{ctx.start}}～{{ctx.end}}条， 总{{ctx.total}}条",
            loading: "加载中...",
            noResults: "没有相关数据",
            refresh: "刷新中...",
            search: "查询中..."
        },
        formatters:{
            "ratio":function(column,row){
                return row.ratio+"%";
            }
        },
    });
</script>