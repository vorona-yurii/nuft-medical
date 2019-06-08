<?php

namespace app\controllers;

use app\models\forms\SettingForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use \Yii;

class SettingController extends Controller
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
                        'actions'      => [ 'index' ],
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
        $model = new SettingForm();
        if( $model->load( Yii::$app->request->post() ) && $model->saveSettings() ){
            Yii::$app->session->setFlash('Налаштування збережено');
        }

        return $this->render( 'index', compact('model') );
    }

}
