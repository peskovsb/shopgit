<?php
use app\models\Identification;
?>

<div id="cartTop">
<?php foreach($items as $value){ ?>
    <div class="cart_id-<?= $value['id'] ?>">
    <?php
    echo  $value['name'] .': '. Identification::addCartQuantity($value['id'],$value['count']);
    echo  Identification::addCartPrice($value['id'],$value['count'],$value['price']);
    echo Identification::addCartPlus($value['id'],'+').' | '.Identification::addCartMinus($value['id'],'-');
    echo ' | '. Identification::addCartDelete($value['id'],'Удалить X');
    ?>
    </div>
<?php } ?>
</div>