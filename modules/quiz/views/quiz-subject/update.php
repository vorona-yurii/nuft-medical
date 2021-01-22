<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\QuizSubject */

$this->title = 'Редагування теми опитування: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Теми опитування', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h1><?= $this->title; ?></h1>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="ibox-content">
                        <div class="row">
                            <?= $this->render('_form', [
                                'model' => $model,
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
