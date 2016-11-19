<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $category app\models\Category */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $category->name;

$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['index']];

$crumbs = [];
$parent = $category;
while ($parent = $parent->parent) {
    $crumbs[] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
}
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], array_reverse($crumbs));

$this->params['breadcrumbs'][] = $this->title;
$this->params['category'] = $category;
//print_r(Yii::$app->request->url);

Pjax::begin();
?>
<div class="catalog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $sort->link('name'); ?>
    <?= $sort->link('price'); ?>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['/catalog/category',
            'id'=>\Yii::$app->request->get('id'),
            'page'=>\Yii::$app->request->get('page'),
            'sort'=>\Yii::$app->request->get('sort'),
            ],
        'options' => ['data-pjax' => true],
        ]
    ); ?>

    <?//= $form->field($model, 'name')->textInput()->label('Введите имя'); ?>
    <?= $form->field($model, 'price')
            ->checkboxList([
                '2000' => 'Category 1',
                '1999' => 'Category 2',
                '20000' => 'Category 3',
            ]);
    ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    <?= Html::a('Очистить фильтры',
        ['/catalog/category',
            'id'=>\Yii::$app->request->get('id'),
            ],
            ['class' => 'btn btn-info']); ?>
    <?php $form::end(); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'itemView' => '_item',
    ]); ?>
</div>

<?php
Pjax::end();
?>
