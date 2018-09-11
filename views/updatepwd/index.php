<!-- Horizontal Form -->

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = '修改密码';
?>
<div class="box box-info">
    <!-- /.box-header -->
    <!-- form start -->
    <?php $form = ActiveForm::begin(['action'=>Url::to(['updatepwd/find'])]) ?>
    <div class="box-body">
        <?= $form->field($regadmin, 'username')->textInput(['value'=>$username,'disabled'=>true])?>
    </div>
        <div class="box-body">
            <?= $form->field($regadmin, 'password')->textInput(['type'=>'password']) ?>
        </div>
        <div class="box-body">
            <?= $form->field($regadmin, 'newsPassword')->textInput(['type'=>'password']) ?>
        </div>
        <div class="box-body">
            <?= $form->field($regadmin, 'confirmPassword')->textInput(['type'=>'password']) ?>
        </div>
</div>

        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" name="save" id="btn" data-ui-loader="" >确定</button>
            <button type="reset" class="btn btn-primary" name="save" id="btn" data-ui-loader="" >取消</button>
        </div>
        <!-- /.box-footer -->
    <?php ActiveForm::end(); ?>
</div>