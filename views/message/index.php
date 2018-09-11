
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
<?php $form = ActiveForm::begin() ?>
<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
<div class="form-group">
    <?php if($username):?>
        <?= $form->field($message,'username')->textInput(['value'=>$username,])?>
    <?php else:?>
    <?= $form->field($message, 'username')->textInput()?>
    <?php endif;?>
</div>
<div class="form-group">
    <?= $form->field($message, 'title')->textInput()?>
</div>
<div class="form-group">
    <?= $form->field($message, 'content')->textArea(['rows' => 8])?>
</div>
<!-- textarea -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">发送</button>
</div>
<?php ActiveForm::end(); ?>