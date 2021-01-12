<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public $layout = '@app/views/layouts/inner.php';

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('login');
    }

    public function actionError()
    {
        if (\Yii::$app->user->isGuest) {
            $this->layout = 'frontend';
        }
        return $this->render('error');
    }
}
