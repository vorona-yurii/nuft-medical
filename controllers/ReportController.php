<?php

namespace app\controllers;

use app\models\search\EmployeeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use \Yii;

class ReportController extends Controller
{
    public $layout = '@app/views/layouts/inner.php';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions'      => [ 'employee' ],
                        'allow'        => true,
                        'roles'        => [ '@' ],
                        'denyCallback' => function ( $rule, $action ) {
                            return $action->controller->redirect( [ 'user/login' ] );
                        },
                    ],
                ],

            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect( ['employee'] );
    }

    /**
     * @return string
     */
    public function actionEmployee()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render(  'employee', compact('searchModel', 'dataProvider') );
    }
}
