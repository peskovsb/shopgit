<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Identification;
use Yii;

class CartController extends Controller
{

    public function actionBuy()
    {
        $id = Yii::$app->request->post('id');
        $count = Yii::$app->request->post('count');
        $model = new Identification;
        $model->addToCart($id,$count);

        return $this->renderPartial('buy');
    }

    public function actionCorrect()
    {
        $id = Yii::$app->request->post('id');
        $count = Yii::$app->request->post('count');
        $model = new Identification;
        $model->correctCart($id,$count);
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $model = new Identification;
        $model->deleteFromCart($id);
    }
}