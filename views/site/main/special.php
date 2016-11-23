<?php
use yii\helpers\Url;
use app\models\Identification;
?>
<div class="special">
    <div class="container">
        <h3>Special Offers</h3>
        <div class="specia-top">
            <ul class="grid_2">
                <?php foreach($special as $item){ ?>
                    <li class="good_id-<?= $item['id'] ?>">
                        <a href="<?= Url::toRoute(['catalog/view','id'=>$item['id']])?>">
                            <img
                                src="<?= \Yii::getAlias('@web').'/uploads/thumb/'. $item->getFirstImg() ?>"
                                class="img-responsive" alt="">
                        </a>
                        <div class="special-info grid_1 simpleCart_shelfItem">
                            <h5><?= $item['name'] ?></h5>
                            <?= Identification::addPlus($item['id'],'+'); ?>
                            <?= Identification::addMinus($item['id'],'-'); ?>
                            <?= Identification::addQuantity(); ?>

                            <div class="item_add">
                                <span class="item_price">
                                    <h6><?= Identification::addPrise($item['price']); ?></h6>
                                </span>
                            </div>
                            <div class="item_add">
                                <span class="item_price">
                                    <?= Identification::addBuy($item['id'],'купить'); ?>
                                </span>
                            </div>
                        </div>
                    </li>
                <?php } ?>
                <div class="clearfix"> </div>
            </ul>
        </div>
    </div>
</div>