<?php
namespace app\components\Cart;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;
use Yii;
use yii\helpers\Url;

class CartWidget extends Widget{
    public $items;
    public $output;

    public function init(){
        parent::init();
        echo '<div style="margin:20px;border:1px solid #ccc;padding:20px;">';
        foreach($this->items as $value){
            $prod = \app\models\Product::findOne(['id'=>$value['id']]);

            echo '<div class="cart_id-'.$value['id'].'">';
            echo 'Items '.$value['id'].': <input data-id="'.$value['id'].'" type="text"
            onblur="cartCorrect(\''.Url::to(["catalog/correct"]).'\',\''.$value['id'].'\',\'cart\')"
            onkeyup="cartCorrect(\''.Url::to(["catalog/correct"]).'\',\''.$value['id'].'\',\'cart\')"
            class="countCart" value="'.$value['count'].'">';
            echo '<span style="display:none;" data-id="'.$value['id'].'" class="priseCart">'.$prod['price'].'</span>';
            echo '<span data-id="'.$value['id'].'" class="priseModifyCart">'.($value['count']*$prod['price']).'</span>';
            echo '<a onclick="cartPlus(\''.Url::to(["catalog/correct"]).'\',\''.$value['id'].'\')" data-id="'.$value['id'].'" class="cartPlus" href="javascript:void(0);">+</a> |
            <a onclick="cartMinus(\''.Url::to(["catalog/correct"]).'\',\''.$value['id'].'\')" data-id="'.$value['id'].'" class="cartMinus" href="javascript:void(0);">-</a>';
            echo ' | <a class="cartDelete" data-id="'.$value['id'].'"
            onclick="cartDelete(\''.Url::to(["catalog/delete"]).'\',\''.$value['id'].'\');" href="javascript:void(0);">Удалить [X]</a>';
            echo '</div>';
        }
        echo '</div>';
        //echo '<pre>';print_r($this->items);echo '</pre>';
    }
}