<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = '用户管理';
?>
<style>
    .box_news{font-size:14px;border: 1px solid #ccc;background-image: none;border-radius: 4px;height: 30px; padding: 6px 12px;line-height: 1.42857;}
    .tr_color{background-color: #9F88FF}
    .form-control {
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        color: #fff;
        font-size: 14px;
        height: 34px;
        line-height: 1.42857;
        padding: 6px 12px;
        width: 30%;
    }
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
        margin-bottom: 0;
        padding: 6px 12px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php $form = ActiveForm::begin(['action'=>Url::to(['user/list'])]) ?>
                    用户名：<input type="text" size="18" class="box_news"   name="username" placeholder="用户名" value="">&nbsp;
                    邮箱：<input type="text" size="18" class="box_news"   name="email" placeholder="邮箱" value="">
                    <input type="submit"  class="clear_box" value="查询"/>
                    <?php ActiveForm::end(); ?>
                    <span style="float:right;"><a href="/user/index">添加</a></span>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>邮箱</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                       <?php foreach($user as $resource){
                           ?>
                        <tr>
                            <td><?= Html::encode($resource->id) ?></td>
                            <td><?= Html::encode($resource->username) ?></td>
                            <td><?= Html::encode($resource->email) ?></td>
                            <td><a href="index.php?r=user/update&id=<?= HTML::encode($resource->id)?>">编辑</a>
                                <a href="index.php?r=user/delete&id=<?= HTML::encode($resource->id)?>" onclick="if(confirm('确认删除吗！') == false)return false">删除</a>
                                <a href="index.php?r=reset/reset&username=<?= HTML::encode($resource->username)?>" onclick="if(confirm('确认重置密码吗！') == false)return false">重置密码</a>
                            </td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <?php echo  LinkPager::widget(['pagination' => $pages]); ?>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>