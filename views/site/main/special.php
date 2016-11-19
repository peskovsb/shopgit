<?php
use yii\helpers\Url;
?>
<div class="special">
    <div class="container">
        <h3>Special Offers</h3>
        <div class="specia-top">
            <ul class="grid_2">
                <?php foreach($special as $item){ ?>
                    <li>
                        <a href="<?= Url::toRoute(['catalog/view','id'=>$item['id']])?>">
                            <img
                                src="<?= \Yii::getAlias('@web').'/uploads/thumb/'. $item->getFirstImg() ?>"
                                class="img-responsive" alt="">
                        </a>
                        <div class="special-info grid_1 simpleCart_shelfItem">
                            <h5><?= $item['name'] ?></h5>
                            <div class="item_add"><span class="item_price"><h6><?= number_format($item['price'], 0, '.', ' ') ?></h6></span></div>
                            <div class="item_add"><span class="item_price"><a href="#">add to cart</a></span></div>
                        </div>
                    </li>
                <?php } ?>
                <div class="clearfix"> </div>
            </ul>
        </div>
    </div>
</div>