`<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\modules\quiz\models\QuizSubject;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\quiz\models\search\QuizQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Питання опитування';
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
                            <a href="<?= Url::to(['/quiz/quiz-question/create']) ?>" class="btn btn-primary dim" type="button">
                                <i class="fa fa-plus"></i> Додати питання
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
                            [
                                'attribute' => 'quiz_subject_id',
                                'filter' => ArrayHelper::map(QuizSubject::find()->all(), 'quiz_subject_id', 'name'),
                                'value' => function ($data) {
                                    return $data->quizSubject ? $data->quizSubject->name : '';
                                }
                            ],
                            [
                                'attribute' => 'level',
                                'filter' => [1 => 1, 2 => 2, 3 => 3],
                                'value' => function ($data) {
                                    return $data->level;
                                }
                            ],
                            'content:ntext',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'headerOptions' => ['width' => '105'],
                                'buttons' => [
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-pencil"></i>', ['/quiz/quiz-question/update', 'id' => $key],
                                            [
                                                'class' => 'btn btn-primary',
                                                'title' => 'Змінити',
                                            ]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-trash"></i>', ['/quiz/quiz-question/delete', 'id' => $key],
                                            [
                                                'title' => 'Видалити',
                                                'class' => 'btn btn-danger',
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'data-confirm' => 'Ви впевнені, що хочете видалити це питання?'
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
</div>`