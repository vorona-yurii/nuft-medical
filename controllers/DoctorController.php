<?php

namespace app\controllers;

use app\models\Doctor;
use app\models\forms\DoctorForm;
use app\models\search\DoctorSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use \Yii;

class DoctorController extends Controller
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
                        'actions'      => [ 'list', 'change', 'delete' ],
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
        return $this->redirect( ['list'] );
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $searchModel = new DoctorSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render(  'list', compact('searchModel', 'dataProvider') );
    }

    /**
     * @param $action
     * @param int $id
     *
     * @return string|\yii\web\Response
     */
    public function actionChange($action, $id = 0 )
    {
        if( !$model = DoctorForm::findOne(['doctor_id' => $id]) ){
            $model = new DoctorForm();
        }

        if( method_exists($model, $action) ) {
            if ( Yii::$app->request->isPost && $model->load( Yii::$app->request->post() ) ) {
                if ( $model->$action() ) {
                    Yii::$app->session->setFlash( 'success', 'Лікаря успішно додано' );
                    return $this->redirect( [ 'doctor/list' ] );
                } else {
                    Yii::$app->session->setFlash( 'error', 'Помилка збереження' );
                }
            }

            return $this->render( 'edit', compact( 'model', 'id' ) );
        }

        return $this->redirect( ['list'] );
    }

    /**
     * @return bool
     */
    public function actionDelete()
    {
        $i = Yii::$app->request->post( 'id' );
        if ( $doctor = Doctor::findOne($i) ) {

            if ( Yii::$app->request->isAjax && $doctor ) {
                /** @var object $doctor */
                $doctor->delete();
                return true;
            }

        }

        return false;
    }

}
