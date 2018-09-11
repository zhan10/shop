
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = '用户管理';
?>
<div class="box box-primary">
    <!-- form start -->
    <?php $form = ActiveForm::begin(['action'=>Url::to(['user/edit'])]) ?>
    <div class="box-body">
        <div class="form-group">
            <?= Html::activeHiddenInput($user,'id',array('value'=>$id)) ?>
        </div>
        <div class="form-group">
            <?= $form->field($user, 'username')->textInput() ?>
        </div>
        <div class="form-group">
            <?= $form->field($user, 'email')->textInput() ?>
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">修改</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>