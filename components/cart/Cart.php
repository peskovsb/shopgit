<?php
namespace app\components\Cart;

use app\models\Identification;
use yii\base\Widget;
use Yii;

class Cart extends Widget{
    public function run(){
        Identification::checkUser();

        $quant = 0;
        $sumCheck = 0;
        $goods = '';
        if(Yii::$app->session->isActive && Yii::$app->session->get('cartCondition')){
            $quant = count(Yii::$app->session->get('cartCondition'));
            foreach(Yii::$app->session->get('cartCondition') as $value){
                $prod = \app\models\Product::findOne(['id'=>$value['id']]);
                $sumCheck += $value['count']*$prod['price'];
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