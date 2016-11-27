<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StaticSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staticpages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'detailtext') ?>

    <?= $form->field($model, 'pics') ?>

    <?= $form->field($model, 'previewtext') ?>

    <?php // echo $form->field($model, 'statuspage') ?>

    <?php // echo $form->field($model, 'dttm') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
