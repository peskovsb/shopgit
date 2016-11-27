<?php

namespace app\controllers;

use Yii;
use app\models\Staticpages;
use app\models\StaticSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;

/**
 * StaticController implements the CRUD actions for Staticpages model.
 */
class StaticController extends Controller
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
     * Lists all Staticpages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaticSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Staticpages model.
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
     * Creates a new Staticpages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staticpages();
        $upload = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {

            // -- UPLOAD FRAGMENT ---------------------
            $upload->prodpics = \yii\web\UploadedFile::getInstances($upload, 'prodpics');

            if($upload->prodpics){
                if ($json = $upload->uploadWide()) {
                    $model->pics = $json[0];
                }else{
                    throw new NotFoundHttpException('Upload failed!');
                }
            }
            // -- UPLOAD FRAGMENT ---------------------

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'upload' => $upload
            ]);
        }
    }

    /**
     * Updates an existing Staticpages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $upload = new UploadForm();
        $model->dttm = \Yii::$app->formatter->asDate( $model->dttm, 'php:Y-m-d');

        if ($model->load(Yii::$app->request->post())) {
            // -- UPLOAD FRAGMENT ---------------------
            $upload->prodpics = \yii\web\UploadedFile::getInstances($upload, 'prodpics');

            if($upload->prodpics){
                if ($json = $upload->uploadWide()) {
                    $model->pics = $json[0];
                }else{
                    throw new NotFoundHttpException('Upload failed!');
                }
            }
            // -- UPLOAD FRAGMENT ---------------------

            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'upload' => $upload
            ]);
        }
    }

    /**
     * Deletes an existing Staticpages model.
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
     * Finds the Staticpages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staticpages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staticpages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionShowstatic(){
        $this->layout = "catalog";
        $model = new StaticSearch();
        $model->alias = Yii::$app->request->get('alias');
        if($model->validate() && $modelGet = Staticpages::findOne(['alias'=>$model->alias])){

        }else{
            throw new NotFoundHttpException('Wrong Params');
        }

        return $this->render('showstatic',[
            'model' => $modelGet
        ]);
    }
}
