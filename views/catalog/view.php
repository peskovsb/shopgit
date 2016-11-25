<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Identification;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['index']];

$crumbs = [];
$parent = $model->category;
$crumbs[] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
while ($parent = $parent->parent) {
    $crumbs[] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
}
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], array_reverse($crumbs));

$this->params['breadcrumbs'][] = $this->title;
$this->params['category'] = $model->category;

$this->registerJsFile(\Yii::getAlias('@web').'/js/jquery.etalage.min.js', [
    'position' => yii\web\View::POS_HEAD,
    'depends'=>'yii\web\YiiAsset']);


//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS
$('#etalage').etalage({
    thumb_image_width: 300,
    thumb_image_height: 400,
    source_image_width: 900,
    source_image_height: 1200,
    show_hint: true,
    click_callback: function(image_anchor, instance_id){
alert('Callback example:You clicked on an image with the anchor: "'+image_anchor+'"(in Etalage instance: "'+instance_id+'")');
}
});
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);


?>

<!-- content -->
<div class="container">
<div class="women_main">
<!-- start content -->
<div class="row single">
<div class="col-md-9 det">
    <div class="single_left">
        <div class="grid images_3_of_2">
            <ul id="etalage">

                <?php
                if(count($model->getAllImgs())>0){
                    foreach ($model->getAllImgs() as $item){ ?>
                        <li>
                            <a href="optionallink.html">
                                <img class="etalage_thumb_image"
                                     src="<?= \Yii::getAlias('@web').'/uploads/thumb/'. $item ?>"
                                     class="img-responsive" />
                                <img class="etalage_source_image"
                                     src="<?= \Yii::getAlias('@web').'/uploads/original/'. $item ?>"
                                     class="img-responsive" title="" />
                            </a>
                        </li>
                <?php
                    }
                }else{ ?>
                    <li>Картинок нет</li>
                <?php }?>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="desc1 span_3_of_2 good_id-<?= $model->id ?>">
            <h3><?= $model->name ?></h3>
            <span class="brand">Brand: <a href="#">Sed do eiusmod </a></span>
            <br>
            <span class="code">Product Code: Product 11</span>
            <p>when an unknown printer took a galley of type and scrambled it to make</p>
            <div class="price">
                <span class="text">Price:</span>
                <span class="price-new"><?= Identification::addPrise($model->price) ?> руб</span><span class="price-old"><?= number_format($model->price+3000, 0, '.', ' ') ?> руб</span>
                <br>
                <span class="points"><small>Баллы при покупке: 400</small></span><br>
            </div>
            <div class="det_nav1">
                <h4>Выберите размер :</h4>
                <div class=" sky-form col col-4">
                    <ul>
                        <li><label class="checkbox"><input type="checkbox" name="checkbox"><i></i>L</label></li>
                        <li><label class="checkbox"><input type="checkbox" name="checkbox"><i></i>S</label></li>
                        <li><label class="checkbox"><input type="checkbox" name="checkbox"><i></i>M</label></li>
                        <li><label class="checkbox"><input type="checkbox" name="checkbox"><i></i>XL</label></li>
                    </ul>
                </div>
            </div>

                <?= Identification::addPlus($model->id,'+'); ?>
                <?= Identification::addMinus($model->id,'-'); ?>
                <?= Identification::addQuantity(); ?>
                <div class="btn_form">
                    <?= Identification::addBuy($model->id,'купить'); ?>
                </div>
                <a href="#"><span>login to save in wishlist </span></a>

        </div>
        <div class="clearfix"></div>
    </div>
    <div class="single-bottom1">
        <h6>Details</h6>
        <p class="prod-desc"><?= $model->content?></p>
    </div>
    <div class="single-bottom2">
        <h6>Related Products</h6>
        <div class="product">
            <div class="product-desc">
                <div class="product-img">
                    <img src="<?= \Yii::getAlias('@web') ?>/images/w8.jpg" class="img-responsive " alt=""/>
                </div>
                <div class="prod1-desc">
                    <h5><a class="product_link" href="#">Excepteur sint</a></h5>
                    <p class="product_descr"> Vivamus ante lorem, eleifend nec interdum non, ullamcorper et arcu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="product_price">
                <span class="price-access">$597.51</span>
                <button class="button1"><span>Add to cart</span></button>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="product">
            <div class="product-desc">
                <div class="product-img">
                    <img src="<?= \Yii::getAlias('@web') ?>/images/w10.jpg" class="img-responsive " alt=""/>
                </div>
                <div class="prod1-desc">
                    <h5><a class="product_link" href="#">Excepteur sint</a></h5>
                    <p class="product_descr"> Vivamus ante lorem, eleifend nec interdum non, ullamcorper et arcu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="product_price">
                <span class="price-access">$597.51</span>
                <button class="button1"><span>Add to cart</span></button>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="w_sidebar">
        <div class="w_nav1">
            <h4>All</h4>
            <ul>
                <li><a href="women.html">women</a></li>
                <li><a href="#">new arrivals</a></li>
                <li><a href="#">trends</a></li>
                <li><a href="#">boys</a></li>
                <li><a href="#">girls</a></li>
                <li><a href="#">sale</a></li>
            </ul>
        </div>
        <h3>filter by</h3>
        <section  class="sky-form">
            <h4>catogories</h4>
            <div class="row1 scroll-pane">
                <div class="col col-4">
                    <label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>kurtas</label>
                </div>
                <div class="col col-4">
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>kutis</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>churidar kurta</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>salwar</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>printed sari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox" ><i></i>shree</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Anouk</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>biba</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>fashion sari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>fashion sari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>fashion sari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>fashion sari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>fashion sari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>fashion sari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>fashion sari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>fashion sari</label>
                </div>
            </div>
        </section>
        <section  class="sky-form">
            <h4>brand</h4>
            <div class="row1 scroll-pane">
                <div class="col col-4">
                    <label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>shree</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Anouk</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>biba</label>
                </div>
                <div class="col col-4">
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>vishud</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>amari</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>shree</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Anouk</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>biba</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox" ><i></i>shree</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Anouk</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>biba</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>shree</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Anouk</label>
                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>biba</label>
                </div>
            </div>
        </section>
        <section class="sky-form">
            <h4>colour</h4>
            <ul class="w_nav2">
                <li><a class="color1" href="#"></a></li>
                <li><a class="color2" href="#"></a></li>
                <li><a class="color3" href="#"></a></li>
                <li><a class="color4" href="#"></a></li>
                <li><a class="color5" href="#"></a></li>
                <li><a class="color6" href="#"></a></li>
                <li><a class="color7" href="#"></a></li>
                <li><a class="color8" href="#"></a></li>
                <li><a class="color9" href="#"></a></li>
                <li><a class="color10" href="#"></a></li>
                <li><a class="color12" href="#"></a></li>
                <li><a class="color13" href="#"></a></li>
                <li><a class="color14" href="#"></a></li>
                <li><a class="color15" href="#"></a></li>
                <li><a class="color5" href="#"></a></li>
                <li><a class="color6" href="#"></a></li>
                <li><a class="color7" href="#"></a></li>
                <li><a class="color8" href="#"></a></li>
                <li><a class="color9" href="#"></a></li>
                <li><a class="color10" href="#"></a></li>
            </ul>
        </section>
        <section class="sky-form">
            <h4>discount</h4>
            <div class="row1 scroll-pane">
                <div class="col col-4">
                    <label class="radio"><input type="radio" name="radio" checked=""><i></i>60 % and above</label>
                    <label class="radio"><input type="radio" name="radio"><i></i>50 % and above</label>
                    <label class="radio"><input type="radio" name="radio"><i></i>40 % and above</label>
                </div>
                <div class="col col-4">
                    <label class="radio"><input type="radio" name="radio"><i></i>30 % and above</label>
                    <label class="radio"><input type="radio" name="radio"><i></i>20 % and above</label>
                    <label class="radio"><input type="radio" name="radio"><i></i>10 % and above</label>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="clearfix"></div>
</div>
<!-- end content -->
</div>
</div>
