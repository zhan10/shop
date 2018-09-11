
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = '用户管理';
?>
<div class="box box-primary">
    <!-- form start -->
    <?php $form = ActiveForm::begin(['action'=>Url::to(['user/add'])]) ?>
        <div class="box-body">
            <div class="form-group">
                <?= $form->field($admin, 'username')->textInput()?>
            </div>
            <div class="form-group">
                <?= $form->field($admin, 'email')->textInput()?>
            </div>
            <div class="form-group">
                <?= $form->field($admin, 'password_hash')->passwordInput()?>
            </div>
            <div class="form-group">
                <?= $form->field($admin, 'confirmPassword')->passwordInput()?>
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">添加</button>
        </div>
    <?php ActiveForm::end(); ?>
</div>