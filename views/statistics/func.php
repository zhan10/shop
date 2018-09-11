<?php
$this->title = '功能图表';
?>
<html>
<head>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="row">
    <div class="col-md-6">
        <!-- DONUT CHART -->
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">功能付费公司总量统计</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div style="top: 0px;left: 0px;height: 5px">
                    <div style='top:0px;left:0px;width:20px; height:10px;background-color: #f56954;display: inline-block'></div><span>任务管理</span><br>
                    <div style='top:0px;left:0px;width:20px; height:10px;background-color: #00a65a;display: inline-block'></div><span>投票管理</span><br>
                    <div style='top:0px;left:0px;width:20px; height:10px;background-color: #f39c12;display: inline-block'></div><span>新闻管理</span><br>
                    <div style='top:0px;left:0px;width:20px; height:10px;background-color: #00c0ef;display: inline-block'></div><span>wiki</span><br>
                </div>
                <canvas id="pieChart" style="height:250px"></canvas>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
    <!-- /.col (LEFT) -->
    <div class="col-md-6">
        <!-- LINE CHART -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">功能每月付费公司量统计</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="lineChart" style="height:258px"></canvas>
                    <div style="top:0px;">
                        <span>任务管理</span><div style='top:0px;left:0px;width:30px; height:10px;background-color: #f56954;display: inline-block'></div>
                        <span>投票管理</span><div style='top:0px;left:0px;width:30px; height:10px;background-color: #00a65a;display: inline-block'></div>
                        <span>新闻管理</span><div style='top:0px;left:0px;width:30px; height:10px;background-color: #f39c12;display: inline-block'></div>
                        <span>wiki</span> <div style='top:0px;left:0px;width:30px; height:10px;background-color: #00c0ef;display: inline-block'></div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col (RIGHT) -->
    <div class="col-md-6">
        <!-- Bar CHART -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title">功能总收费统计</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="barChart" style="height:300px"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<script src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../adminJs/bootstrap/js/bootstrap.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="../../adminJs/plugins/chartjs/Chart.min.js"></script>
<!-- FastClick -->
<script src="../../adminJs/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../adminJs/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../adminJs/dist/js/demo.js"></script>
<script src="../../adminJs/flot/jquery.flot.categories.min.js"></script>
<script>
    $(function () {
        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartData = {
            labels: <?=json_encode($turnoverDate)?>,
            datasets: [
                {
                    label: "任务管理",
                    fillColor: "rgba(210, 214, 222, 1)",
                    strokeColor: "#f56954",
                    pointColor: "#f56954",
                    pointStrokeColor: "#f56954",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: <?=json_encode($task)?>
                },{
                    label: "投票管理",
                    fillColor: "rgba(210, 214, 222, 1)",
                    strokeColor: "#00a65a",
                    pointColor: "#00a65a",
                    pointStrokeColor: "#00a65a",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: <?=json_encode($polls)?>
                },{
                    label: "新闻管理",
                    fillColor: "rgba(210, 214, 222, 1)",
                    strokeColor: "#f39c12",
                    pointColor: "#f39c12",
                    pointStrokeColor: "#f39c12",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: <?=json_encode($breakingnews)?>
                },
                {
                    label: "wiki",
                    fillColor: "rgba(210, 214, 222, 1)",
                    strokeColor: "#00c0ef",
                    pointColor: "#00c0ef",
                    pointStrokeColor: "#00c0ef",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: <?=json_encode($wiki)?>
                },

            ]
        };
        var lineChartOptions ={
            //Boolean - If we should show the scale at all
            showScale: true,
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
        lineChartOptions.datasetFill = false;
        lineChart.Line(lineChartData, lineChartOptions);

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
            {
                value: <?=$sqldate['2']['cnt']?>,
                color: "#f56954",
                highlight: "#f56954",
                label: "任务管理"
            },
            {
                value: <?=$sqldate['1']['cnt']?>,
                color: "#00a65a",
                highlight: "#00a65a",
                label: "投票管理"
            },
            {
                value: <?=$sqldate['0']['cnt']?>,
                color: "#f39c12",
                highlight: "#f39c12",
                label: "新闻管理"
            },
            {
                value: <?=$sqldate['3']['cnt']?>,
                color: "#00c0ef",
                highlight: "#00c0ef",
                label: "wiki"
            }
        ];
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
        //- BAR CHART -
        //-------------
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = {
            labels: ["新闻管理", "投票管理", "任务管理", "wiki"],
            datasets: [
                /*{
                 label: "Electronics",
                 fillColor: "rgba(210, 214, 222, 1)",
                 strokeColor: "rgba(210, 214, 222, 1)",
                 pointColor: "rgba(210, 214, 222, 1)",
                 pointStrokeColor: "#c1c7d1",
                 pointHighlightFill: "#fff",
                 pointHighlightStroke: "rgba(220,220,220,1)",
                 data: [65, 59, 80, 81, 56, 55, 40,100,120,150,120,100,]
                 }*/
                {

                    fillColor: "rgba(60,141,188,0.8)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: <?=json_encode($func)?>
                },
                /*
                 {
                 label: "南京",
                 fillColor: "rgba(120,210,188,0.5)",
                 strokeColor: "rgba(120,210,188,0.5)",
                 pointColor: "#c1c7d1",
                 pointStrokeColor: "rgba(120,210,188,0.5)",
                 pointHighlightFill: "#fff",
                 pointHighlightStroke: "rgba(120,210,188,0.5)",
                 data: [80, 85, 20, 19, 20, 27, 50]
                 }*/
            ]
        };
        //barChartData.datasets[1].fillColor = "#00a65a";
        //barChartData.datasets[1].strokeColor = "#00a65a";
        // barChartData.datasets[1].pointColor = "#00a65a";
        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);

    });

</script>
</body>
</html>
