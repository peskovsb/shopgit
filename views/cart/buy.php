<?php
use app\components\cart\CartWidget;

if(Yii::$app->session->isActive){
    echo 'Выводим данные со списком покупок';
    //echo CartWidget::widget();
}