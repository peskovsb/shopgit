<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Staticpages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staticpages-form">

    <?php if($model->pics){ ?>
        <img src="<?= Yii::getAlias('@web').'/uploads/thumb/'.$model->pics ?>">
    <?php } ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detailtext')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'custom', 'clientOptions' => [
            'toolbarGroups' => [

                ['name'=>'links','groups'=>['mode']],
                ['name' => 'basicstyles', 'groups' => ['basicstyles']],
                ['name'=> 'paragraph', 'groups' => [ 'list', 'indent' ]],
                ['name'=> 'align'],
                ['name'=> 'styles'],
                ['name'=> 'colors'],
            ]
        ]
    ]) ?>

    <?= $form->field($upload, 'prodpics[]')
        ->fileInput(['accept' => 'image/*']); ?>

    <?= $form->field($model, 'previewtext')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'statuspage')->checkbox() ?>

    <?= $form->field($model, 'dttm')->widget(
        DatePicker::className(), [
        // inline too, not bad
        'inline' => true,
        // modify template for custom rendering
        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(
    '$("document").ready(function(){
        $("#formPics").on("pjax:end", function() {
        $.pjax.reload({container:"#showPics"});  //Reload GridView
    });
});'
);
?>