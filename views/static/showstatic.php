<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 27.11.16
 * Time: 22:05
 */

?>
<div class="container">
    <h1><?= $model-> titlename?></h1>
    <img style="width:100%;" src="<?= Yii::getAlias('@web').'/uploads/thumb/'.$model->pics?>">
    <?= $model-> detailtext?>
</div>