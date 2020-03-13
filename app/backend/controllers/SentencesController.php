<?php

namespace app\controllers;

use app\models\FooForm;
use Yii;
use app\models\Sentences;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SentencesController implements the CRUD actions for Sentences model.
 */
class SentencesController extends Controller
{

    public function beforeAction($action)
    {
       
        if (Yii::$app->user->isGuest && Yii::$app->getRequest()->url !== Url::to(Yii::$app->getUser()->loginUrl) && $action->actionMethod != 'actionCounfromfile') {
            Yii::$app->getResponse()->redirect(Yii::$app->getUser()->loginUrl);
        }
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
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
     * Lists all Sentences models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Sentences::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sentences model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sentences model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sentences();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sentences model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sentences model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sentences model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sentences the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sentences::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 
     * @return mixed
     */
    public function actionCount()
    {
        $sentence = Yii::$app->request->get('sentence');
        $result = Yii::$app->string->fetchCountValues($sentence);

        (new Sentences(['value' => $sentence, 'result' => json_encode($result)]))->save();        

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @return string
     */
    public function actionCounfromfile()
    {
        $model = new FooForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            $sentence = file_get_contents($model->file->tempName);

            $result = Yii::$app->string->fetchCountValues($sentence);
            (new Sentences(['value' => $sentence, 'result' => serialize($result)]))->save();

            return $this->render('show', ['data' => $result]);
        }

        return $this->render('upload', ['model' => $model]);
    }
}
