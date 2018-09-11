<?php
$this->title = '首页';
?>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../../css/morris.css">
    <script src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="../../adminJs/jqGrid/jquery.bootgrid.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <style>
        .status{
            background-color:#46be8a;
            padding: .25em .6em .25em;
            border-radius: .3em;
            color: #fff;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">CPU</span>
                    <span class="info-box-number">90<small>%</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">公司总数</span>
                    <span class="info-box-number"><?=$array['companyTotal']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">用户总数</span>
                    <span class="info-box-number"><?=$array['userTotal']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">当前在线人数</span>
                    <span class="info-box-number"><?=$array['currentOnline']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">内存</span>
                    <span class="info-box-number"><?=$memory?><small>%</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">当月营业额</span>
                    <span class="info-box-number"><?=$array['dataTurnover']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">当月新增公司数量</span>
                    <span class="info-box-number"><?=$array['thisDateNewCompany']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">最高在线人数</span>
                    <span class="info-box-number"><?=$array['highestCurrentOnline']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
</section>
<!--        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">每月新增收入额</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                      </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="thisMonthNewIncome" style="height:250px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">各模块每月收入</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" style="height:250px"></canvas>
                            <div style="margin:0 auto; width:400px; height:25px; border:1px solid #ffffff;">
                                <?php /*foreach ($moduleArray as $key=>$value) {
                                   echo"<div style='width:10px; height:10px; background: $color[$key];display: inline-block'></div><span style='color:$color[$key];text-align: center'>$key&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                                }*/?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
<div class="row">
    <div class="col-md-6">
        <!-- AREA CHART -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">入驻俱乐部会员人数</h3>
                <div style="margin-top: 10px;margin-left: 10px;width:450px; height:25px; border:1px solid #ffffff;">
                    <span style='color:#0a0a0a;text-align: center'>俱乐部会员已达：<span style='color:red;text-align: center;font-size: 20px'>859人</span></span>
                </div>
                <div style="width:450px; height:25px; border:1px solid #ffffff;margin-top: 10px; margin-left: 10px;">
                    <div style='width:10px; height:10px; background:#a0d0e0 ;display: inline-block'></div>&nbsp;<span style='color:#a0d0e0;text-align: center'>银卡：573人&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <div style='width:10px; height:10px; background:#3c8dbc ;display: inline-block'></div>&nbsp;<span style='color:#3c8dbc;text-align: center'>金卡：253人&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <div style='width:10px; height:10px; background:#01ff70 ;display: inline-block'></div>&nbsp;<span style='color:#01ff70;text-align: center'>铂金卡：22人&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <div style='width:10px; height:10px; background:#00E8D7 ;display: inline-block'></div>&nbsp;<span style='color:#00E8D7;text-align: center'>钻石卡：11人&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart" id="revenue-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">新申请入驻企业</h3>
                <table id="grid-data" style="margin-top: 30px" class="table table-condensed table-hover table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>企业名</th>
                        <th>入住时间</th>
                        <th>状态</th>
                    </tr>
                    </thead>
                    <tbody id="corp">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="../../adminJs/plugins/morris.min.js"></script>
<script src="../../adminJs/plugins/fastclick.js"></script>
<script src="../../adminJs/plugins/demo.js"></script>
<script src="../../adminJs/plugins/app.min.js"></script>
<script src="../../adminJs/plugins/chartjs/Chart.min.js"></script>
<?php
echo "<script>";
echo "var total=[];";
echo "var color=[];";
foreach ($moduleArray   as $key=> $value   ) {
    echo " total['$key']= $value;";
}
foreach ($color   as $key=> $value   ) {
    echo " color['$key']= '$value';";
}
echo "</script>";
?>
<script>
    $(function () {
        $.ajax({
            "type": "POST", "success": function (data) {
                var json_Array = JSON.parse(data);
                for(var i=0;i<json_Array.length;i++){
                    var str = replace(json_Array[i]['isQualified']);
                    $("#corp").append(
                        "<tr>" +
                        "<td>"+json_Array[i]['rownum']+"</td>" +
                        "<td>"+json_Array[i]['companyName']+"</td>" +
                        "<td>"+json_Array[i]['createTime']+"</td>" +
                        "<td>"+str+"</td>" +
                        "</tr>"
                    );
                }
            },
            "url":"?r=dashboard/find-new-corp"
        });
        function replace(isQualified){
            if(isQualified==0){
                return '<span class="status">未审核</span>';
            }else if(isQualified==1){
                return '<span class="status">待审核</span>';
            }else if(isQualified==2){
                return '<span class="status">已验证</span>';
            }else if(isQualified==3){
                return '<span class="status">验证失败</span>';
            }
        }
        $.ajax({
            "type": "GET", "success": function (data) {
                var json_Array = JSON.parse(data);
                level(json_Array);
            },
            "url":"?r=dashboard/find-level"
        });
        function level(data){
            var area = new Morris.Area({
                element: 'revenue-chart',
                resize: true,
                data: data,
                xkey: 'time',
                ykeys: ['10','20','30','40'],
                labels: ['银卡', '金卡','白金卡','钻石卡'],
                lineColors: ['#a0d0e0', '#3c8dbc','#01ff70','#00E8D7'],
                hideHover: 'auto'
            });
        }
        var areaChartData = {
            labels: <?=json_encode($turnoverDate)?>,
            datasets: [
                {
                    label: "Digital Goods",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: <?=json_encode($turnover)?>
                }
            ]
        };
        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //网格线
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            //线条是否弯曲
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };
        //-------------
        //- LINE CHART -
        //--------------
        /*var lineChartCanvas = $("#thisMonthNewIncome").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        lineChart.Line(areaChartData, lineChartOptions);*/
        var moduleData = {
            labels: <?=json_encode($date)?>,
            datasets: [
            ]
        };
        /*var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        var colorArray = [];
        for(var key in total){
            moduleData['datasets'].push({
                label:key ,
                fillColor: "rgba(60,141,188,0.9)",
                //线条颜色
                strokeColor: color[key],
                pointColor: color[key],
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data:total[key]
            });
        }
        lineChart.Line(moduleData, lineChartOptions);*/
    });
</script>
</body>
</html>
