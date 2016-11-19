<?php
use app\components\cart\CartWidget;

if(Yii::$app->session->isActive){
    echo CartWidget::widget(['items'=>Yii::$app->session->get('cartCondition')]);
}