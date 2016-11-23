<?php
namespace app\components\Cart;

use yii\base\Widget;
use Yii;

class CartBuying extends Widget{
    public function run(){

        $items = [];
        if(Yii::$app->session->get('cartCondition')){
            $items = Yii::$app->session->get('cartCondition');
        }

        return $this->render('buyingview', [
            'items'=>$items
        ]);
    }
}