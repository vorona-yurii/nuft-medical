<?php

namespace app\modules\quiz\controllers;

use Yii;
use app\modules\quiz\models\QuizQuestion;
use app\modules\quiz\models\search\QuizQuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * QuizQuestionController implements the CRUD actions for QuizQuestion model.
 */
class QuizQuestionController extends Controller
{
    public $layout = 'inner';

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
                    'ajax-delete-image' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all QuizQuestion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuizQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new QuizQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new QuizQuestion();

        if ($model->load(Yii::$app->request->post())) {
            $model->media = UploadedFile::getInstance($model, 'media');
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing QuizQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->media = UploadedFile::getInstance($model, 'media');
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing QuizQuestion model.
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
     * @param $id
     * @return bool
     * @throws NotFoundHttpException
     */
    public function actionAjaxDeleteImage($id)
    {
        $question = $this->findModel($id);
        if (is_file(Yii::getAlias('@web/' . $question->image))) {
            unlink(Yii::getAlias('@web/' . $question->image));
        }
        $question->image = null;
        $question->save();

        return true;
    }

    /**
     * Finds the QuizQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuizQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QuizQuestion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Питання не знайдено.');
    }
}
