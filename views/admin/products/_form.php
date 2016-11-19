<?php

use app\models\Category;
use app\models\Tag;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $values app\models\Value[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php yii\widgets\Pjax::begin(['id' => 'formPics']) ?>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-pjax' => true,'style'=>'display:none;']]); ?>

        <?= $form->field($upload, 'prodpics[]')
            ->fileInput(
                ['multiple' => true,
                    'class'=>'prodClickBtn',
                    'accept' => 'image/*','onchange'=>'$(".formSubm").click();
                    $(".loading").show();$("#loaderbtn").remove()']); ?>

        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary formSubm']) ?>

        <?php ActiveForm::end(); ?>

    <?php yii\widgets\Pjax::end(); ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">


            <?= $form->field($model, 'category_id')->dropDownList(Category::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'price')->textInput() ?>

            <?= $form->field($model, 'active')->textInput() ?>

            <?php yii\widgets\Pjax::begin(['id' => 'showPics','enablePushState'=>false]) ?>
            <a id="loaderbtn" style="display:block" href="javascript:void(0);" onclick="$('.prodClickBtn').click();">Закачать фотку</a>
            <div class="loading" style="display: none">Загрузка</div>
            <div id="picscontainer">
            <?php
            if($model->prodpics){
                $jsonDecode = json_decode($model->prodpics);
                foreach($jsonDecode as $key => $pics){
                    echo '<img style="display:inline-block" src="'.Yii::getAlias('@web').'/uploads/thumb/'.$pics.'">';
                    echo Html::a('del'.($key+1),['admin/products/update','id'=>$model->id,'del'=>$key+1]);
                }
            }
            ?>
            </div>

            <?php yii\widgets\Pjax::end(); ?>

            <?= $form->field($model, 'tagsArray')->checkboxList(Tag::find()->select(['name', 'id'])->indexBy('id')->column()) ?>
        </div>
        <div class="col-md-6">
            <?php foreach ($values as $value): ?>
                <?= $form->field($value, '[' . $value->productAttribute->id . ']value')->label($value->productAttribute->name); ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
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