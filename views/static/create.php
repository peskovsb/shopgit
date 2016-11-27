<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Staticpages */

$this->title = 'Create Staticpages';
$this->params['breadcrumbs'][] = ['label' => 'Staticpages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staticpages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
