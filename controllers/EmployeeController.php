<?php

namespace app\controllers;

use app\models\Employee;
use app\models\forms\EmployeeForm;
use app\models\forms\ImportForm;
use app\models\search\EmployeeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use \Yii;

class EmployeeController extends Controller
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
                        'actions'      => [ 'list', 'change', 'delete', 'import' ],
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
        $searchModel = new EmployeeSearch();
        $importModel = new ImportForm();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render(  'list', compact('searchModel', 'importModel', 'dataProvider') );
    }

    public function actionImport()
    {
        $importModel = new ImportForm();

        $messages = null;
        if (Yii::$app->request->isPost && $importModel->load( Yii::$app->request->post() )) {
            $messages = $importModel->import();
            if ($messages) {
                $glue = '<br/>';
                if ($messages['results']) {
                    Yii::$app->session->setFlash( 'success', implode($glue, $messages['results']) );
                }
                if ($messages['errors']) {
                    Yii::$app->session->setFlash( 'error', implode($glue, $messages['errors']) );
                }
                if ($messages['warnings']) {
                    Yii::$app->session->setFlash( 'warning', implode($glue, $messages['warnings']) );
                }
            }
        }

        if (!$messages) {
            Yii::$app->session->setFlash( 'error', 'Помилка імпорту' );
        }

        return $this->redirect( [ 'employee/list' ] );
    }

    /**
     * @param $action
     * @param int $id
     *
     * @return string|\yii\web\Response
     */
    public function actionChange($action, $id = 0 )
    {
        if( !$model = EmployeeForm::findOne(['employee_id' => $id]) ){
            $model = new EmployeeForm();
        }

        if( method_exists($model, $action) ) {
            if ( Yii::$app->request->isPost && $model->load( Yii::$app->request->post() ) ) {
                if ( $model->$action() ) {
                    Yii::$app->session->setFlash( 'success', 'Працівника успішно додано' );
                    return $this->redirect( [ 'employee/list' ] );
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
        if ( $employee = Employee::findOne($i) ) {

            if ( Yii::$app->request->isAjax && $employee ) {
                /** @var object $employee */
                $employee->delete();
                return true;
            }

        }

        return false;
    }

}
