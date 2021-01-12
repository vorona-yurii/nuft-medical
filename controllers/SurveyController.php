<?php

namespace app\controllers;

use app\modules\quiz\models\QuizEmployee;
use yii\filters\AccessControl;
use yii\web\Controller;

class SurveyController extends Controller
{
    public $layout = 'frontend';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $token
     * @return string
     */
    public function actionIndex($token = '')
    {
        if ($quiz_employee = QuizEmployee::findOne(['token' => $token])) {
            return $this->render('index', [
                'quiz' => $quiz_employee->quiz,
                'employee' => $quiz_employee->employee
            ]);
        }
        return 'Опитування не знайдено!';
    }
}