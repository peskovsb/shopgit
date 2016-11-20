<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use app\models\Tag;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Identification;
use Yii;

class CartController extends Controller
{
    /**
     * @author Peskov Sergey
     * date: 17.09.2016
     * Позже эти action'ы будут перенесены
     * в контроллер CatalogController
     * отвечает за ajax добавление в корзину
     * @return db_record INSERT/UPDATE
     */
    public function actionBuy()
    {
        $id = Yii::$app->request->post('id');
        $count = Yii::$app->request->post('count');
        $model = new Identification;
        $model->addToCart($id,$count);

        return $this->renderPartial('buy');
    }
}