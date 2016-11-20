<?
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

class Identification extends Model
{
    /**
     * @author Peskov Sergey
     * Проверка существования Coockie
     * @date 16.09.2016
     * @return boolen true/false
    */
    static function checkUser(){
        if(isset($_COOKIE['user']) || Yii::$app->session->get('userId')){
            if(isset($_COOKIE['user'])){
                Yii::$app->session->set('userId', $_COOKIE['user']);
            }
            $idUser = isset($_COOKIE['user']) ? $_COOKIE['user'] : Yii::$app->session->get('userId');
            if(Yii::$app->session->get('checkBuy')){
                if(is_array(Yii::$app->session->get('cartCondition'))){
                    return false;
                }else{
                    $query = new Query;
                    $query->select('cart')
                        ->from('bmb_cart_users')
                        ->where(['user_id'=>$idUser]);
                    $data = $query->one();
                    //print_r($data);

                    if(!empty($data)){
                        //echo 'meFull';
                        Yii::$app->session->set('cartCondition', json_decode($data['cart'],true));
                    }else{
                        //echo 'meEmpty';
                        Yii::$app->session->set('cartCondition', []);
                    }
                }
            }else{
                $query = new Query;
                $query->select(['user_id','cart'])
                    ->from('bmb_cart_users')
                    ->where(['user_id'=>$idUser]);
                $data = $query->one();
                if(isset($data['user_id'])){
                    Yii::$app->session->set('checkBuy', true);
                    Yii::$app->session->set('cartCondition', json_decode($data['cart'],true));
                }else{
                    Yii::$app->session->set('checkBuy', 'nope');
                    Yii::$app->session->set('cartCondition', []);
                }
            }
        }else{
            $randID = 'guest_' . time() . '_' . rand(100,10000);
            setcookie("user", $randID, time()+(3600*24*183),'/');
            if(!Yii::$app->session->get('userId')){
                Yii::$app->session->set('userId', $randID);
            }
        }
    }

    /**
     * @author Peskov Sergey
     * Добавление записи в корзину
     * @date 17.09.2016
     * @param id товара, count количество
     * @return boolen true/false
     */
    public function addToCart($id,$count=1){
        if(Yii::$app->session->get('checkBuy')===true){
            $getCond = Yii::$app->session->get('cartCondition');
            $exists = 0;
            if($count<=0){
                $count=1;
            }
            foreach($getCond as $key=>$value){
                if($value['id']==$id){
                    $getCond[$key]['count'] = $value['count'] + $count;
                    $exists = 1;
                    break;
                }
            }
            if($exists!=1){
                $res = ['id'=>$id,'count'=>$count];
                $getCond[] = $res;
            }
            Yii::$app->session->set('cartCondition',$getCond);
            $dataCart = json_encode($getCond, JSON_UNESCAPED_UNICODE);
            Yii::$app->db->createCommand()->update('bmb_cart_users', [
                'user_id' => Yii::$app->session->get('userId'),
                'cart' => $dataCart,
            ], 'user_id=:id', [':id'=>Yii::$app->session->get('userId')])->execute();
        }else{
            $res = [
                ['id'=>$id,'count'=>$count]
            ];
            $dataCart = json_encode($res, JSON_UNESCAPED_UNICODE);
            Yii::$app->session->set('cartCondition',$res);
            Yii::$app->db->createCommand()->insert('bmb_cart_users', [
                'user_id' => Yii::$app->session->get('userId'),
                'cart' => $dataCart,
            ])->execute();
            Yii::$app->session->set('checkBuy', true);
        }
    }

    /**
     * @author Peskov Sergey
     * Удаление записи из корзины
     * @date 17.09.2016
     * @param id товара
     * @return boolen true/false
     */
    public function deleteFromCart($id){
        $getCond = Yii::$app->session->get('cartCondition');
        foreach($getCond as $key=>$value){
            if($value['id']==$id){
                unset($getCond[$key]);
                break;
            }
        }
        foreach($getCond as $key=>$value){
            $getCond[$key]['id'] = $value['id'];
            $getCond[$key]['count'] = $value['id'];
         }
        Yii::$app->session->set('cartCondition',$getCond);
        $dataCart = json_encode($getCond, JSON_UNESCAPED_UNICODE);
        Yii::$app->db->createCommand()->update('bmb_cart_users', [
            'user_id' => Yii::$app->session->get('userId'),
            'cart' => $dataCart,
        ], 'user_id=:id', [':id'=>Yii::$app->session->get('userId')])->execute();
    }

    /**
     * @author Peskov Sergey
     * Изменения количетсва товара в корзине
     * @date 18.09.2016
     * @param id товара, count количество
     * @return boolen true/false
     */
    public function correctCart($id,$count){
        $getCond = Yii::$app->session->get('cartCondition');
        foreach($getCond as $key=>$value){
            if($value['id']==$id){
                $getCond[$key]['count'] = $count;
                break;
            }
        }
        Yii::$app->session->set('cartCondition',$getCond);
        $dataCart = json_encode($getCond, JSON_UNESCAPED_UNICODE);
        Yii::$app->db->createCommand()->update('bmb_cart_users', [
            'user_id' => Yii::$app->session->get('userId'),
            'cart' => $dataCart,
        ], 'user_id=:id', [':id'=>Yii::$app->session->get('userId')])->execute();
    }
}

