<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\quiz\models\search\QuizSubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Теми опитування';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2><?= $this->title ?></h2>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <div class="btn-group pull-right">
                            <a href="<?= Url::to(['/quiz/quiz-subject/create']) ?>" class="btn btn-primary dim" type="button">
                                <i class="fa fa-plus"></i> Додати тему
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="ibox-content">
                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'layout' => '{items}',
                        'columns' => [
                            'name',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'headerOptions' => ['width' => '105'],
                                'buttons' => [
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-pencil"></i>', ['/quiz/quiz-subject/update', 'id' => $key],
                                            [
                                                'class' => 'btn btn-primary',
                                                'title' => 'Змінити',
                                            ]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-trash"></i>', ['/quiz/quiz-subject/delete', 'id' => $key],
                                            [
                                                'title' => 'Видалити',
                                                'class' => 'btn btn-danger',
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'data-confirm' => 'Ви впевнені, що хочете видалити цю тему та всі питання, що до неї прив\'язані?'
                                            ]);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>

                    <?= LinkPager::widget(['pagination' => $dataProvider->pagination]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
