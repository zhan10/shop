<?php
$this->title = '规模分析';
function getValue($data,$sum,$type){
    return round($data[$type]/$sum*100,2);
}
?>
<!-- /.box -->
<script src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="../../adminJs/plugins/chartjs/Chart.min.js"></script>
<div class="box box-danger">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>
            <!-- /.col -->
            <div class="col-md-4" style="margin-top: 120px; font-size: 16px;">
                <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-red"></i> <10人 : <?=getValue($data,$sum,1)?>%</li>
                    <li><i class="fa fa-circle-o text-green"></i> 10~30人 : <?=getValue($data,$sum,2)?>%</li>
                    <li><i class="fa fa-circle-o text-yellow"></i> 30~50人 : <?=getValue($data,$sum,3)?>%</li>
                    <li><i class="fa fa-circle-o text-aqua"></i> 50~100人 : <?=getValue($data,$sum,4)?>%</li>
                    <li><i class="fa fa-circle-o text-light-blue"></i> 100~300人 : <?=getValue($data,$sum,5)?>%</li>
                    <li><i class="fa fa-circle-o" style="color: #000"></i> 300~500人 : <?=getValue($data,$sum,6)?>%</li>
                    <li><i class="fa fa-circle-o text-gray"></i> ≥500人 : <?=getValue($data,$sum,7)?>%</li>
                </ul>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row --><!--
        <canvas id="pieChart" style="width: 60%; height:250px"></canvas>-->
    </div>
    <!-- /.box-body -->
</div>
<script>
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
        {
            value: <?=getValue($data,$sum,1)?>,
            color: "#f56954",
            highlight: "#f56954",
            label: "<10人"
        },
        {
            value: <?=getValue($data,$sum,2)?>,
            color: "#00a65a",
            highlight: "#00a65a",
            label: "10~30人"
        },
        {
            value: <?=getValue($data,$sum,3)?>,
            color: "#f39c12",
            highlight: "#f39c12",
            label: "30~50人"
        },
        {
            value: <?=getValue($data,$sum,4)?>,
            color: "#00c0ef",
            highlight: "#00c0ef",
            label: "50~100人"
        },
        {
            value: <?=getValue($data,$sum,5)?>,
            color: "#3c8dbc",
            highlight: "#3c8dbc",
            label: "100~300人"
        },
        {
            value: <?=getValue($data,$sum,6)?>,
            color: "#000",
            highlight: "#000",
            label: "300~500人"
        },
        {
            value: <?=getValue($data,$sum,7)?>,
            color: "#d2d6de",
            highlight: "#d2d6de",
            label: "≥500人"
        }
    ];
    var pieOptions = {
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>"+"%",
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
</script>
