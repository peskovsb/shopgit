<?php

/* @var $this yii\web\View */

$this->title = 'ShopGIT: Главная страница';

?>

<?= $this->render('main/special', [
    'special' => $special
]); ?>