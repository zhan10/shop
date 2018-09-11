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

    <script type="text/javascript" src="../../adminJs/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.js"></script>
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.min.js"></script>
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.js"></script>
    <script type="text/javascript" src="../../adminJs/jqGrid/jquery.bootgrid.fa.min.js"></script>
</head>
<body>
    <button type="button" class="btn btn-block btn-success" style="width: 50px" id="add"><i class="fa fa-plus"></i></button>
    <table id="grid-selection" class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th data-column-id="id" data-width="50" data-order="asc" data-type="numeric" data-identifier="true">ID</th>
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
    <div id="particularsShow">
        <div id="bg"></div>
        <div id="ss">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#home">企业基础信息</a></li>
                <li><a href="#profile">申请人信息</a></li>
                <li><a href="#messages">企业认证信息</a></li>
                <li><a href="#settings">企业审核信息</a></li>
                <li><input type="button" value="关闭" id="close"></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <form action="?r=management/edit-base" method="post">
                        <table class="org-info">
                            <tbody>
                            <tr>
                                <input type="hidden" name="id" id="baseId">
                                <td class="info-label">企业编号：</td>
                                <td class="info-content"><input type="text" name="innerCode"  id="innerCode" /></td>
                                <td class="info-label">企业名称：</td>
                                <td class="info-content"><input type="text" name="companyName"  id="companyName" /></td>
                            </tr>
                            <tr>
                                <td class="info-label">域名：</td>
                                <td class="info-content"><input type="text" name="domain"  id="domain" /></td>
                                <td class="info-label">所在地：</td>
                                <td class="info-content"><input type="text" name="location"  id="location" /></td>
                            </tr>
                            <tr>
                                <td class="info-label">详细地址：</td>
                                <td class="info-content"><input type="text" name="address" id="address" /></td>
                            </tr>
                            <tr>
                                <td class="info-label">所属行业：</td>
                                <td class="info-content"><input type="text" name="industry" id="industry" /></td>
                            </tr>
                            <tr>
                                <td class="info-label">注册资本：</td>
                                <td class="info-content"><input type="text" name="registeredCapital" id="registeredCapital" /></td>
                                <td class="info-label">年营业额：</td>
                                <td class="info-content"><input type="text" name="turnover"  id="turnover" /></td>
                            </tr>
                            <tr>
                                <td class="info-label">企业需求：</td>
                                <td class="info-content"><input type="text" name="request"  id="request" /></td>
                                <td class="info-label">企业资质：</td>
                                <td class="info-content"><input type="text" name="qualifications"  id="qualifications" /></td>
                            </tr>
                            <tr>
                                <td class="info-label">企业简介：</td>
                                <td class="info-content"><input type="text" name="description" id="description" /></td>
                            </tr>
                            </tbody>
                        </table>
                        <input type="submit" value="提交" class="but">
                    </form>
                </div>
                <div class="tab-pane" id="profile">
                    <form action="?r=management/edit-user" method="post">
                        <table class="org-info">
                            <tbody>
                            <tr>
                                <td class="info-label">申请人：</td>
                                <td class="info-content"><input type="text" name="name" id="name" /></td>
                                <td class="info-label">联系方式：</td>
                                <td class="info-content"><input type="text" name="mobile" id="mobile" /></td>
                            </tr>
                            <tr>
                                <td class="info-label">出生年月：</td>
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
                        <input type="submit" value="提交" class="but">
                    </form>
                </div>
                <div class="tab-pane" id="messages">
                    <form action="?r=management/edit-corp" method="post" enctype ="multipart/form-data">
                        <table class="org-info">
                            <tbody>
                            <tr>
                                <input type="hidden" name="id" id="corpId">
                                <td class="info-label">营业执照号：</td>
                                <td class="info-content"><input type="text" name="orgCode" id="orgCode" /></td>
                            </tr>
                            <tr>
                                <td class="info-label">营业执照：</td>
                                <td class="info-content"><input type="file" name="orgCodeImg" id="orgCodeImg"/></td>
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
                                <td class="info-label">会员级别：</td>
                                <td class="info-content"><input type="text" name="level" id="level" /></td>
                            </tr>
                            </tbody>
                        </table>
                        <input type="submit" value="提交" class="but">
                    </form>
                </div>
                <div class="tab-pane" id="settings">
                    <table class="org-info">
                        <tbody>
                        <tr>
                            <td class="info-label">审核人</td>
                            <td class="info-label">审核操作</td>
                            <td class="info-label">审核时间</td>
                            <td class="info-label">审核建议</td>
                        </tr>
                        <tr>
                            <td class="info-label"></td>
                            <td class="info-label"></td>
                            <td class="info-label"></td>
                            <td class="info-label"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
                                    <select style="width: 140px" id="province" name="province">
                                    </select>
                                </td>
                                <td class="info-content">
                                    <select style="width: 140px" id="city" name="city">
                                        <option selected="selected" value=''>请选择城市</option>
                                    </select>
                                </td>
                                <td class="info-label">
                                    <select style="width: 140px" id="district" name="district">
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
                                <td class="info-label">邮箱：</td>
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

</body>
</html>
<script type="text/javascript" src="../../adminJs/demo.js"></script>
<script>
    $(function () {
        $('.active').tab('show');//初始化显示哪个tab

        $('#myTab a').click(function (e) {
            e.preventDefault();//阻止a链接的跳转行为
            $(this).tab('show');//显示当前选中的链接及关联的content
        })
    })
</script>