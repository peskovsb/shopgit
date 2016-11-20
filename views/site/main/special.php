<?php
use yii\helpers\Url;
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
                            <input type="hidden" value="<?= $item['price'] ?>" class="bsb_prise_prod">
                            <input type="text" value="1" class="countGood">
                            <div class="item_add"><span class="item_price"><h6><?= number_format($item['price'], 0, '.', ' ') ?></h6></span></div>
                            <div class="item_add">
                                <span class="item_price">
                                    <a href="javascript:void(0)" onclick="ajaxAddToCart('/framework/web/cart/buy','<?=$item['id']?>');">купить</a>

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