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
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.min.js"></script>
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.js"></script>
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.min.js"></script>
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
</style>
<body>
<!-- Button trigger modal -->
<button type="button" id="but" class="btn btn-success btn-md" style="width: 50px">
    <i class="fa fa-plus"></i>
</button>
<table id="grid-selection" class="table table-condensed table-hover table-striped">
    <thead>
    <tr>
        <th data-column-id="id" data-width="50" data-order="asc" data-type="numeric" data-identifier="true" data-visible="false">ID</th>
        <th data-column-id="companyName" data-width="300">公司名称</th>
        <th data-column-id="isQualified" data-formatter="isQualified" data-width="100" >资质审核</th>
        <th data-column-id="isEnabled" data-formatter="isEnabled" data-width="60">状态</th>
        <th data-column-id="expendamount" data-formatter="expendamount" data-width="85">消费总额</th>
        <th data-column-id="registeName" data-width="75">管理员</th>
        <th data-column-id="tel" data-width="90">手机号</th>
        <th data-column-id="level" data-formatter="level" data-width="85">会员级别</th>
        <th data-column-id="createTime" data-width="150">创建时间</th>
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
<div id="addShow">
    <div id="bg"></div>
    <div id="ss">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active" id=base><a href="#addHome">企业基础信息</a></li>
            <li><a href="#addProfile" id="proposer">申请人信息</a></li>
            <li><a href="#addMessages" id="corp">企业认证信息</a></li>
            <li><input type="button" value="关闭" id="addClose"></li>
        </ul>
        <form action="?r=management%2Fadd" method="post" enctype ="multipart/form-data">
            <div class="tab-content">
                <div class="tab-pane active" id="addHome">
                    <table class="org-info">
                        <tbody>
                        <tr>
                            <td class="info-label">企业编号*：</td>
                            <td class="info-content"><input type="text" name="innerCode"/></td>
                        </tr>
                        <tr>
                            <td class="info-label">域名*：</td>
                            <td class="info-content"><input type="text" name="domain"/></td>
                            <td class="info-label">企业名称*：</td>
                            <td class="info-content"><input type="text" name="companyName"/></td>
                        </tr>
                        <tr>
                            <td class="info-label">所在地*：</td>
                            <td class="info-label">
                                <select style="width: 140px" id="provinces" name="province">
                                </select>
                            </td>
                            <td class="info-content">
                                <select style="width: 140px" id="citys" name="city">
                                    <option selected="selected" value=''>请选择城市</option>
                                </select>
                            </td>
                            <td class="info-label">
                                <select style="width: 140px" id="districts" name="district">
                                    <option selected="selected" value=''>请选择行政区</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">详细地址*：</td>
                            <td class="info-content"><input type="text" name="address" id="address" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">所属行业*：</td>
                            <td class="info-content">
                                <select style="width: 140px" class="industry" name="industry">
                                </select>
                            </td>
                            <td class="info-label">年营业额：</td>
                            <td class="info-content"><input type="text" name="turnover"  id="turnover" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">注册资本：</td>
                            <td class="info-content"><input type="text" name="registeredCapital" id="registeredCapital" /></td>
                            <td class="info-label">企业资质：</td>
                            <td class="info-content"><input type="text" name="qualifications"  id="qualifications" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">企业需求：</td>
                            <td class="info-content"><input type="text" name="request"  id="request" /></td>
                            <td class="info-label">企业简介：</td>
                            <td class="info-content"><input type="text" name="description" id="description" /></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="but"><input type="button" value="下一步" id="baseNext"></div>
                </div>
                <div class="tab-pane" id="addProfile">
                    <table class="org-info">
                        <tbody>
                        <tr>
                            <td class="info-label">申请人*：</td>
                            <td class="info-content"><input type="text" name="name" id="name" /></td>
                            <td class="info-label">手机号码*：</td>
                            <td class="info-content"><input type="text" name="mobile" id="mobile" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">生日：</td>
                            <td class="info-content"><input type="text" name="birthday" id="birthday" /></td>
                            <td class="info-label">职务：</td>
                            <td class="info-content"><input type="text" name="title" id="title" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">性别：</td>
                            <td class="info-content"><input type="text" name="gender" id="gender" /></td>
                            <td class="info-label">学历：</td>
                            <td class="info-content"><input type="text" name="education" id="education" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">身份证：</td>
                            <td class="info-content"><input type="text" name="identityNr" id="identityNr" /></td>
                            <td class="info-label">政治面貌：</td>
                            <td class="info-content"><input type="text" name="politicalStatus" id="politicalStatus" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">户籍所在地：</td>
                            <td class="info-content"><input type="text" name="domicileLocation" id="domicileLocation" /></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="but"><input type="button" value="下一步" id="next"></div>
                </div>
                <div class="tab-pane" id="addMessages">
                    <table class="org-info">
                        <tbody>
                        <tr>
                            <td class="info-label">营业执照号：</td>
                            <td class="info-content"><input type="text" name="orgCode" id="orgCode" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">营业执照：</td>
                            <td class="info-content">
                                <input type="file" name="orgCodeImg" id="orgCodeImg"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">企业法人：</td>
                            <td class="info-content"><input type="text" name="legalPerson" id="legalPerson" /></td>
                            <td class="info-label">联系方式：</td>
                            <td class="info-content"><input type="text" name="tel" id="tel" /></td>
                        </tr>
                        <tr>
                            <td class="info-label">邮箱*：</td>
                            <td class="info-content"><input type="text" name="email" id="email" /></td>
                            <td class="info-label">会员级别*：</td>
                            <td class="info-content">
                                <select style="width: 140px" id="level" name="level">
                                    <option selected="selected" value=''>请选择</option>
                                    <option value='10'>银卡会员</option>
                                    <option value='20'>金卡会员</option>
                                    <option value='30'>铂金卡会员</option>
                                    <option value='40'>钻石卡会员</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="but"><input type="submit" value="提交"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#baseNext').click(function(){
        $('#proposer').tab('show');
    })
    $('#next').click(function(){
        $('#corp').tab('show');
    });
    $.ajax({"type":"GET","success":function(province){
        var province_array = JSON.parse(province);
        $("#provinces").append("<option selected='selected' value=''>请选择省份</option>");
        for(var i=0;i<province_array.length;i++){
            $("#provinces").append("<option value='"+province_array[i]['zip']+"'>"+province_array[i]['name']+"</option>");
        }
    },"url":"?r=management/get-province"
    });

    $.ajax({"type":"GET","success":function(industry){
        var industry_array = JSON.parse(industry);
        $(".industrys").append("<option selected='selected' value=''>请选择</option>");
        for(var i=0;i<industry_array.length;i++){
            $(".industrys").append("<option value='"+industry_array[i]['name']+"'>"+industry_array[i]['name']+"</option>");
            var sub = (industry_array[i]['sub']+"").split(",");
            for(var j=0;j<sub.length;j++){
                $(".industrys").append("<option value='"+sub[j]+"'>&nbsp; &nbsp; "+sub[j]+"</option>");
            }
        }
    },"url":"?r=management/get-industry"
    });
    $("#provinces").change(function(){
        $("#citys").empty();
        $.ajax({"type":"GET","success":function(citys){
            var city_array = JSON.parse(citys);
            $("#citys").append("<option selected='selected' value=''>请选择城市</option>");
            $("#districts").append("<option selected='selected' value=''>请选择行政区</option>");
            for(var i=0;i<city_array.length;i++){
                $("#citys").append("<option value='"+city_array[i]['zip']+"'>"+city_array[i]['name']+"</option>");
            }
        },"url":"?r=management/get-city","data":'province='+$(this).val()
        });
    });
    $("#citys").change(function(){
        $("#districts").empty();
        $.ajax({"type":"GET","success":function(district){
            var city_array = JSON.parse(district);
            $("#districts").append("<option selected='selected' value=''>请选择行政区</option>");
            for(var i=0;i<city_array.length;i++){
                $("#districts").append("<option value='"+city_array[i]['zip']+"'>"+city_array[i]['name']+"</option>");
            }
        },"url":"?r=management/get-district","data":'city='+$(this).val()
        });
    });
    $("#addClose").click(function(){
        $("#addShow").hide();
    })
    $("#but").click(function(){
        $("#addShow").show();
    });
    $(function () {
        $('.active').tab('show');//初始化显示哪个tab

        $('#myTab a').click(function (e) {
            e.preventDefault();//阻止a链接的跳转行为
            $(this).tab('show');//显示当前选中的链接及关联的content
        })
    })
   /*
    //===============
/*        $("#btnSubmit").bind('click',function () {
        var postData=bsForm.GetFormData();
        alert("获取到的表达数据为:"+JSON.stringify(postData));
    })*!/
    $("#next").bind('click',function () {
        if (!$("#formContainer").valid()) {
            alert("验证没通过！");
        }
        else{
            var postData=bsForm.GetFormData();
            alert("获取到的表达数据为:"+JSON.stringify(postData));
        }
    });
    //使用自定义配置的验证样式处理
    global.Fn.setDefaultValidator();
    //定义验证规则
    $("#formContainer").validate({
        rules:{
            UserName:{
                required:true,
                minlength:3,
                maxlength:10
            },
            ProductName:{required:true}
        }
    });*/
</script>
<script src="../../adminJs/companyForm.js"></script>
<script src="../../adminJs/companyGird.js"></script>

</body>
</html>

