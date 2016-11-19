<?php

namespace app\controllers\admin;

use app\models\Attribute;
use app\models\Value;
use Yii;
use app\models\Product;
use app\models\UploadForm;
use app\models\admin\search\ProductSearch;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Product model.
 */
class ProductsController extends Controller
{
    public $layout = 'layoutadmin';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $upload = new UploadForm();
        $values = $this->initValues($model);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save() && Model::loadMultiple($values, $post)) {
            $this->processValues($values, $model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'values' => $values,
                'upload' => $upload
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $values = $this->initValues($model);
        $upload = new UploadForm();
        $json = array();

        $post = Yii::$app->request->post();

        if (!Yii::$app->request->isAjax) {
            if(Yii::$app->request->get('del')){
                return $this->redirect(
                    Url::to([Yii::$app->controller->id.'/'.Yii::$app->controller->action->id,
                        'id'=>$id])
                );
            }
        }

        if (Yii::$app->request->isAjax) {
            $model = $this->findModel($id);
            if(Yii::$app->request->get('del')){
                if($model->prodpics){
                    $jsonDecode = json_decode($model->prodpics);
                    unset($jsonDecode[(Yii::$app->request->get('del')-1)]);
                    $jsonDecode = UploadForm::my_sort($jsonDecode);
                    $json = json_encode($jsonDecode);
                    $model->prodpics = $json;
                    Yii::$app->db->createCommand()->update(Product::tableName(),
                        [
                            'prodpics' => $json
                        ], 'id=:id', [':id'=>$id])
                        ->execute();
                    //return $this->redirect(['update', 'id' => $model->id]);
                }
            }

            $upload->prodpics = \yii\web\UploadedFile::getInstances($upload, 'prodpics');

            if($upload->prodpics){
                if($model->prodpics){
                    $jsonDecode = json_decode($model->prodpics);
                    $json = $jsonDecode;
                }
                if ($filesJson = $upload->upload()) {
                    $json = array_merge ($json,$filesJson);
                    $json = json_encode($json);
                    $model->prodpics = $json;
                    if($model->save()){
                        //saved
                    }else{
                        echo 'errror';
                    }
                }else{
                    throw new NotFoundHttpException('Upload failed!');
                }
            }
        }else{

            if ($model->load($post) && $model->validate()) {

                if($model->save() && Model::loadMultiple($values, $post)){
                    $this->processValues($values, $model);
                    //return $this->redirect(['update', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
                'model' => $model,
                'values' => $values,
                'upload' => $upload
            ]);

    }




    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param Product $model
     * @return Value[]
     */
    private function initValues(Product $model)
    {
        /** @var Value[] $values */
        $values = $model->getValues()->with('productAttribute')->indexBy('attribute_id')->all();
        $attributes = Attribute::find()->indexBy('id')->all();

        foreach (array_diff_key($attributes, $values) as $attribute) {
            $values[$attribute->id] = new Value(['attribute_id' => $attribute->id]);
        }

        foreach ($values as $value) {
            $value->setScenario(Value::SCENARIO_TABULAR);
        }
        return $values;
    }

    /**
     * @param Value[] $values
     * @param Product $model
     */
    private function processValues($values, Product $model)
    {
        foreach ($values as $value) {
            $value->product_id = $model->id;
            if ($value->validate()) {
                if (!empty($value->value)) {
                    $value->save(false);
                } else {
                    $value->delete();
                }
            }
        }
    }
}
