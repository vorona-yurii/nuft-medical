<?php

namespace app\modules\quiz\controllers;

use app\modules\quiz\models\QuizEmployeeForm;
use Yii;
use app\modules\quiz\models\QuizEmployee;
use app\modules\quiz\models\search\QuizEmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuizEmployeeController implements the CRUD actions for QuizEmployee model.
 */
class QuizEmployeeController extends Controller
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
                    'send-answers' => ['POST']
                ],
            ],
        ];
    }

    /**
     * @param $quiz_id
     * @return string
     */
    public function actionIndex($quiz_id)
    {
        $searchModel = new QuizEmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $quiz_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'quiz_id' => $quiz_id
        ]);
    }

    public function actionJoin($quiz_id)
    {
        $model = new QuizEmployeeForm($quiz_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'quiz_id' => $quiz_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSendAnswers($id)
    {
        $employee = $this->findModel($id);
        $employee->show_explanation = 1;
        $employee->save();

        $employee->sendAnswersToEmployee();
        $quiz_id = $employee->quiz_id;

        Yii::$app->session->setFlash('success', 'Відповіді успішно відправлені працівнику');

        return $this->redirect(['index', 'quiz_id' => $quiz_id]);
    }

    /**
     * Deletes an existing QuizEmployee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $employee = $this->findModel($id);
        $quiz_id = $employee->quiz_id;
        $employee->delete();

        return $this->redirect(['index', 'quiz_id' => $quiz_id]);
    }

    /**
     * Finds the QuizEmployee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuizEmployee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QuizEmployee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
