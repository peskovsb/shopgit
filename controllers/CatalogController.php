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

class CatalogController extends Controller
{
    public $layout = 'catalog';

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->active()->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategory($id)
    {
        $category = $this->findCategoryModel($id);

        $model = new Product;
        //self::show($category);

        $sort = new \yii\data\Sort([
            'attributes' => [
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Name',
                ],
                //'name',
                'price',
            ],
        ]);


        $query = Product::find()->active()->forCategory($category->id)->orderBy($sort->orders);

        if($model->load(\Yii::$app->request->get())){
            $query->andWhere(['price'=>$model->price]);
        }
        //print_r($model->category_id);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);
        //self::show($dataProvider);
        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'sort' => $sort,
        ]);
    }

    public function actionTag($tag)
    {
        $tag = $this->findTagModel($tag);

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->active()->forTag($tag->id)->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('tag', [
            'tag' => $tag,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findProductModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCategoryModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param string $name
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findTagModel($name)
    {
        if (($model = Tag::findOne(['name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProductModel($id)
    {
        if (($model = Product::findOne(['id'=>$id,'active'=>1])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    static function show($array){
        echo '<pre style="margin:80px;">'; print_r($array); echo '</pre>';
    }

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
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $model = new Identification;
        $model->deleteFromCart($id);
        return $this->renderPartial('delete');
    }
    public function actionCorrect()
    {
        $id = Yii::$app->request->post('id');
        $count = Yii::$app->request->post('count');
        $model = new Identification;
        $model->correctCart($id,$count);
        return $this->renderPartial('correct');
    }
    public function beforeAction($action) {
        Identification::checkUser();
        return true;
    }
}
