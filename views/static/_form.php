<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Staticpages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staticpages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detailtext')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pics')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'previewtext')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'statuspage')->textInput() ?>

    <?= $form->field($model, 'dttm')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
