<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '公司管理';
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../adminJs/jqGrid/jquery.bootgrid.min.css" />
    <link rel="stylesheet" type="text/css" href="../../adminJs/jqGrid/jquery.bootgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/company.css" />
    <link rel="stylesheet" href="../../css/site.css">
    <link rel="stylesheet" href="../../adminJs/substep/bootstrap-datetimepicker.min.css" />
    <!--<script src="./lib/jquery.js"></script>-->
    <script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.js"></script>
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.js"></script>
    <script src="../../adminJs/lib/jquery.validate.js"></script>
   <!-- <script src="../../adminJs/lib/bootstrap.js"></script>-->
    <!--工具方法-->
    <script src="../../adminJs/scripts/global.js"></script>
    <!--插件-->
    <script src="../../adminJs/scripts/jquery.smart-form.js"></script>
    <script src="../../adminJs/lib/jquery-file-upload/vendor/jquery.ui.widget.js"></script>
    <script src="../../adminJs/lib/jquery-file-upload/jquery.fileupload.js"></script>
</head>
<style>
    .form-group{
        margin-left:10px;
    }
    .formSub{
        margin-right: 50px;
    }
    .error{
        color:red;
        font-size: 8px;
    }
    .inputStyle{
        border-color: red;
    }
    .mask {
        position: absolute; top: 0px; filter: alpha(opacity=60); background-color: #777;
        z-index: 1002; left: 0px;
        opacity:0.5; -moz-opacity:0.5;
        text-align: center;
    }
</style>
<body>
<!-- Button trigger modal   data-toggle="modal"  data-target="#addMyModal"-->
<button type="button" id="but" class="btn btn-success btn-md" style="width: 50px">
    <i class="fa fa-plus"></i>
</button>
<table id="grid-selection" class="table table-condensed table-hover table-striped">
    <thead>
    <tr>
        <th data-column-id="id" data-width="50" data-order="asc" data-type="numeric" data-identifier="true" data-visible="false">ID</th>
        <th data-column-id="companyName" data-width="25%">公司名称</th>
        <th data-column-id="isQualified" data-formatter="isQualified" data-width="8%" >资质审核</th>
        <th data-column-id="isEnabled" data-formatter="isEnabled" data-width="6%">状态</th>
        <!-- <th data-column-id="expendamount" data-formatter="expendamount" data-width="8%">消费总额</th>
         <th data-column-id="registeName" data-width="7%">管理员</th>
         <th data-column-id="tel" data-width="10%">手机号</th>-->
        <th data-column-id="industry" data-formatter="industry" data-width="10%">所在行业</th>
        <th data-column-id="level" data-formatter="level" data-width="8%">会员级别</th>
        <th data-column-id="createTime" data-width="15%">创建时间</th>
        <th data-column-id="operation" data-formatter="operation" data-sortable="false">操作</th>
    </tr>
    </thead>
</table>
<!--时间插件-->
<script src="../../adminJs/substep/bootstrap-datetimepicker.js"></script>
<script src="../../adminJs/substep/bootstrap-datetimepicker.zh-CN.js"></script>
<!-- Modal -->
<div class="container">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="myTab">
                        <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">企业基础信息</a></li>
                        <li role="presentation"><a href="#profile" role="tab" data-toggle="tab">申请人信息</a></li>
                        <li role="presentation"><a href="#messages" role="tab" data-toggle="tab">企业认证信息</a></li>
                    </ul>
                </div>
                <div class="modal-body modal-lg"  style="margin-left: 60px;">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <form action="?r=management/edit-base" method='post' id="formBase" class="form-horizontal"></form>
                            <div class="panel-heading">
                                <label></label>
                                <div class="pull-right">
                                    <button class="btn btn-primary formSub" onclick="baseVerify();">提交</button>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <form action="?r=management/edit-user" method='post' id="formUser" class="form-horizontal"></form>
                            <div class="panel-heading">
                                <label></label>
                                <div class="pull-right">
                                    <button class="btn btn-primary formSub" onclick="userVerify();">提交</button>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages">
                            <form action="?r=management/edit-corp" method='post' id="formCorp" enctype ="multipart/form-data" class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">营业执照:</label>
                                    <div class="col-sm-4">
                                        <input type="file" id="orgCodeImg" name="orgCodeImg">
                                    </div>
                                </div>
                            </form>
                            <div class="panel-heading">
                                <label></label>
                                <div class="pull-right">
                                    <button class="btn btn-primary formSub" onclick="corpVerify();">提交</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="consumptionMoney">
    <div id="bg"></div>
    <div id="ss">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>公司名</th>
                <th>模块名称</th>
                <th>订单编号</th>
                <th>价格</th>
                <th>时间/月</th>
                <th>开启时间</th>
                <th>结束时间</th>
            </tr>
            </thead>
            <tbody id="consumeRecord">
            </tbody>
        </table>
        <div class="butClose"><input type="button" value="关闭" id="butClose"></div>
    </div>
</div>
<div class="container">
    <div class="modal fade" id="addMyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="adf">
            <div class="modal-content">
                <div id="mask" class="mask" style="display:none;">
                    <img src="../../images/loading.jpg" style="padding-top: 40px;"/>
                    <h2 style="color: #ffffff">正在创建公司数据请稍等....</h2>
                </div>
                <div class="modal-header">
                    <button type="button" id="close" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="myTab">
                        <li role="presentation" class="active"><a href="#homes">企业基础信息</a></li>
                        <li role="presentation"><a href="#profiles">申请人信息</a></li>
                        <li role="presentation"><a href="#messagess">企业认证信息</a></li>
                    </ul>
                </div>
                <div class="modal-body modal-lg">
                    <form role="form" class="form-horizontal" action="?r=management%2Fadd" method="post" id="addForm" enctype ="multipart/form-data">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="homes">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">企业编号:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="innerCode" id="innerCodes" placeholder="企业编号">
                                        <span id="innerCodeError" class="error"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">域名*:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="domain" id="domains" placeholder="域名">
                                        <span id="domainError" class="error"></span>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">企业名称*:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="companyName" id="companyNames" placeholder="企业名称">
                                        <span id="companyNameError" class="error"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">所在地*:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="provinces" name="province"></select>
                                        <span id="provinceError" class="error"></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="citys" name="city">
                                            <option selected="selected" value=''>请选择城市</option>
                                        </select>
                                        <span id="cityError" class="error"></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="districts" name="district">
                                            <option selected="selected" value=''>请选择行政区</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">详细地址*:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="address" id="addresss" placeholder="详细地址">
                                        <span id="addressError" class="error"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">所属行业*:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="industrys" name="industry"></select>
                                        <span id="industryError" class="error"></span>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">年营业额:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="turnover" placeholder="年营业额">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">注册资本:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="registeredCapital">
                                            <option selected="selected" value=''>请选择注册资本</option>
                                            <option value='1'><100万元</option>
                                            <option value='2'>100~500万元</option>
                                            <option value='3'>500~1000万元</option>
                                            <option value='4'>1000~5000万元</option>
                                            <option value='5'>5000~10000万元</option>
                                            <option value='6'>≥10000万元</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">企业资质:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="qualifications" placeholder="企业资质">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">企业需求:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="request" placeholder="企业需求">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">企业简介:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="description" placeholder="企业简介">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="#profile" type="button" class="btn btn-primary" id="Next" style="float:right;margin:15px">下一步</a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profiles">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">申请人*:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="name" id="names" placeholder="申请人">
                                        <span id="nameError" class="error"></span>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">手机号码*:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="mobile" id="mobiles" placeholder="手机号码">
                                        <span id="mobileError" class="error"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">生日:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="birthdays" name="birthday" placeholder="生日">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">职务:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="title" placeholder="职务">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">性别:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="gender" placeholder="性别">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">学历:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="education" placeholder="学历">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">身份证:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="identityNr" placeholder="身份证">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">政治面貌:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="politicalStatus" placeholder="政治面貌">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">户籍所在地:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="domicileLocation" placeholder="户籍所在地">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="sNext">上一步</button>
                                    <button type="button" class="btn btn-primary" id="baseNext" style="float:right;margin:15px">下一步</button>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="messagess">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">营业执照号:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="orgCode" placeholder="营业执照号">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">营业执照:</label>
                                    <div class="col-sm-4">
                                        <input type="file" name="orgCodeImg">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">企业法人:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="legalPerson" placeholder="企业法人">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">联系方式:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="tel" placeholder="联系方式">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">邮箱*:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="email" placeholder="邮箱" id="emails">
                                        <span id="emailsError" class="error"></span>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">会员级别*:</label>
                                    <div class="col-sm-4">
                                        <select name="level" class="form-control" id="levels">
                                            <option selected="selected" value=''>请选择</option>
                                            <option value='10'>银卡会员</option>
                                            <option value='20'>金卡会员</option>
                                            <option value='30'>铂金卡会员</option>
                                            <option value='40'>钻石卡会员</option>
                                        </select>
                                        <span id="levelsError" class="error"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="ssNext">上一步</button>
                                    <button type="button" class="btn btn-primary" style="float:right;margin:15px;" id="addSub">提交</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        //兼容火狐、IE8
        //显示遮罩层
        function showMask(){
            $("#mask").css("height",$("#adf").height());
            $("#mask").css("width",$("#adf").width());
            $("#mask").show();
        }
        //隐藏遮罩层
        function hideMask(){
            $("#mask").hide();
        }

</script>
<script src="../../adminJs/company.js"></script>
<script src="../../adminJs/companyValidate.js"></script>
<script src="../../adminJs/companyForm.js"></script>
<script src="../../adminJs/companyGird.js"></script>

</body>
</html>

