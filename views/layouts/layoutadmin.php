<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\components\cart\CartWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<script type="text/javascript">

    goods = [<?php
            if(Yii::$app->session->isActive && Yii::$app->session->get('cartCondition')){
                foreach(Yii::$app->session->get('cartCondition') as $value){
                    echo $value['id'].', ';
                }
            }
        ?>];
</script>
<?php
//echo count(Yii::$app->session->get('cartCondition'));
$cartSum = 0;
$sumCheck = 0;
if(Yii::$app->session->isActive && Yii::$app->session->get('cartCondition')){
    $cartSum = count(Yii::$app->session->get('cartCondition'));
    foreach(Yii::$app->session->get('cartCondition') as $value){
        $sumCheck += $value['count']*50;
    }
}
echo '<div>Корзина <span id="countInfo">'.$cartSum.'</span> | <span id="priseInfo">'.$sumCheck.'</span> руб</div>';

echo '<div id="cartTop">';
if(Yii::$app->session->isActive && Yii::$app->session->get('cartCondition')){
    echo CartWidget::widget(['items'=>Yii::$app->session->get('cartCondition')]);
}
echo '</div>';

?>

<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Catalog', 'url' => ['/catalog/index']],
            ['label' => 'Админка', 'items' => [
                ['label' => 'Товары', 'url' => ['/admin/products/index']],
                ['label' => 'Разделы', 'url' => ['/admin/categories/index']],
                ['label' => 'Свойства', 'url' => ['/admin/attributes/index']],
                //['label' => 'Values', 'url' => ['/admin/values/index']],
                ['label' => 'Тэги', 'url' => ['/admin/tags/index']],
                //['label' => 'Product Tags', 'url' => ['/admin/product-tags/index']],
            ]],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
