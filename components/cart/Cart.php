<?php
namespace app\components\Cart;

use app\models\Identification;
use yii\base\Widget;
use Yii;

class Cart extends Widget{
    public $cart;
    public function run(){
        Identification::checkUser();

        $getProds = Identification::getProductCart();
        $quant = 0;
        $sumCheck = 0;
        $goods = '';

        if(Yii::$app->session->isActive && Yii::$app->session->get('cartCondition')){

            $quant = count(Yii::$app->session->get('cartCondition'));
            foreach(Yii::$app->session->get('cartCondition') as $value){
                $price = '';
                if(count($getProds)>0){
                    foreach($getProds as $prod){
                        if($value['id']==$prod['id']){
                            $price = $prod['price'];
                        }
                    }
                }

                $sumCheck += $value['count']*$price;
                $goods .= $value['id'].', ';
            }
        }

        $script = "goods = [".$goods."];";
        $this->view->registerJs($script, yii\web\View::POS_READY);

        echo '<input id="bcb_base_quantity" type="hidden" value="'.$quant.'">';
        echo '<input id="bcb_base_sum" type="hidden" value="'.$sumCheck.'">';

        return $this->render('cartview',[
            'sum' => $sumCheck,
            'quantity' => $quant
        ]);
    }
}