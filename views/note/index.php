
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = '消息通知';
?>
<div class="box-footer">
    <a href="index.php?r=message/index"><input type="submit" class="btn btn-primary" value="通知个人"></a>&nbsp;&nbsp;
    <a href="index.php?r=note/index"><input type="submit" class="btn btn-primary" value="通知所有人"></a>
</div>
<?php $form = ActiveForm::begin(['action'=>Url::to(['note/create'])]) ?>
<div class="form-group">
    <?= $form->field($model, 'title')->textInput()?>
</div>
<div class="form-group">
    <?= $form->field($model, 'content')->textArea(['rows' => 8])?>
</div>
<!-- textarea -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">发送</button>
</div>
<?php ActiveForm::end(); ?>