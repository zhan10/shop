<?php
$this->title = '首页';
?>
<script src="/plug-in/ueditor/ueditor.config.js"></script>
<script src="/plug-in/ueditor/ueditor.all.js"></script>
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">新增</button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">精彩活动-新增</h4>
            </div>
            <div class="modal-body">
                <form action="/dashboard" method="get" id="add">
                    <!-- 加载编辑器的容器 -->
                    <script id="container" name="content" type="text/plain">这里写你的初始化内容</script>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary a">提交更改</button>
            </div>
        </div>
    </div>
</div>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    $(".a").click(function(){
        $("#add").submit();
    });
    var ue = UE.getEditor('container');
</script>
