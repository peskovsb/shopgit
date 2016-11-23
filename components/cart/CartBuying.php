<?php
namespace app\components\Cart;

use app\models\Identification;
use yii\base\Widget;
use Yii;

class CartBuying extends Widget{

    public function run(){

        $getProds = Identification::getProductCart();
        $items = [];
        $out = [];
        if(Yii::$app->session->get('cartCondition')){
            foreach(Yii::$app->session->get('cartCondition') as $value){
                $price = '';
                if(count($getProds)>0){
                    foreach($getProds as $prod){
                        if($value['id']==$prod['id']){
                            $price = $prod['price'];
                            $name = $prod['name'];
                        }
                    }
                }
                $items = $value;
                $items['price'] = $price;
                $items['name'] = $name;
                $out[] = $items;
            }
        }

        return $this->render('buyingview', [
            'items'=>$out
        ]);
    }
}