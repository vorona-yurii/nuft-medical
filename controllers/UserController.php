<?php

namespace app\controllers;

use Yii;
use app\models\forms\LoginForm;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
{
    public $layout = '@app/views/layouts/inner.php';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect('login');
                }
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        //return $this->render('index');
        return $this->redirect(['/employee']);
    }

    /**
     * @return $this|string
     */
    public function actionLogin()
    {
        $this->layout = '@app/views/layouts/login.php';

        $model = new LoginForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->login() ) {
            return $this->redirect(['/user']);
        }

        return $this->render( 'login', compact('model') );
    }

    /**
     * @return
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('login');
    }
}