<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$tagLinks = [];
foreach ($model->tags as $tag) {
    $tagLinks[] = Html::a(Html::encode($tag->name), ['tag', 'tag' => $tag->name]);
}

?>

<div class="good_id-<?= $model->id ?> prodelemet">
    <b><?= $model->name ?></b>
    <?php
    if($model->prodpics){
        $jsonDecode = json_decode($model->prodpics); ?>
        <div>
            <img src="/web/uploads/thumb/<?= $jsonDecode[0] ?>">
        </div>

    <?php } ?>
    <p><?php if ($tagLinks): ?>
    <p>Tags: <?= implode(', ', $tagLinks) ?></p>
    <?php endif; ?></p>

    <input type="text" value="1" class="countGood">
    <div class="priseGood"><?= $model->price ?></div>
    <div>
        <a href="javascript:void(0);" onclick="countMinus('<?= $model->id ?>');">-</a>
        <a href="javascript:void(0);" onclick="countPlus('<?= $model->id ?>');">+</a>
    </div>
    <a class="addToCartBtn addToCartAction" href="javascript:void(0)" onclick="ajaxAddToCart('/web/catalog/buy','<?= $model->id ?>');">купить</a>
</div>