<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Employee;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\quiz\models\search\QuizEmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $quiz_id integer */

$this->title = 'Працівники | Опитування #' . $quiz_id;
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
                            <a href="<?= Url::to(['/quiz/quiz-employee/join', 'quiz_id' => $quiz_id]) ?>" class="btn btn-primary dim" type="button">
                                <i class="fa fa-plus"></i> Вибрати працівників</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="ibox-content">
                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'filterModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'layout' => '{items}',
                        'columns' =>
                            [
                                [
                                    'filter' => Select2::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'employee_id',
                                        'data' => ArrayHelper::map(Employee::find()->all(), 'employee_id', 'full_name'),
                                        'options' => [
                                            'class' => 'form-control',
                                            'placeholder' => 'Виберіть працівника'
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'selectOnClose' => true,
                                        ]
                                    ]),
                                    'attribute' => 'employee_id',
                                    'value' => function ($data) {
                                        return $data->employee->full_name;
                                    }
                                ],
                                [
                                    'attribute' => 'passed',
                                    'filter' => [1 => 'Так', 0 => 'Ні'],
                                    'value' => function ($data) {
                                        return $data->passed ? 'Так': 'Ні';
                                    }
                                ],
                                [
                                    'attribute' => 'token',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        $links = '<a data-pjax="0" target="_blank" href="' . Url::to(['/survey/index', 'token' => $data->token]) . '">Опитування</a>';
                                        if ($data->passed) {
                                            $links .= ' / <a data-pjax="0" target="_blank" href="' . Url::to(['/survey/explanation', 'token' => $data->token]) . '">Відповіді</a>';
                                        }
                                        return $links;
                                    }
                                ],
                                [
                                    'attribute' => 'score',
                                    'filter' => false
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete} {send_answers}',
                                    'headerOptions' => ['width' => '100'],
                                    'buttons' => [
                                        'delete' => function ($url, $model, $key) {
                                            return Html::a('<i class="fa fa-trash"></i>', ['/quiz/quiz-employee/delete', 'id' => $key],
                                                [
                                                    'title' => 'Видалити',
                                                    'class' => 'btn btn-danger',
                                                    'data-method' => 'post',
                                                    'data-pjax' => '0',
                                                    'data-confirm' => 'Ви впевнені, що хочете видалити праівника з опитування?'
                                                ]);
                                        },
                                        'send_answers' => function ($url, $model, $key) {
                                            return $model->passed ? Html::a('<i class="fa fa-paper-plane"></i>', ['/quiz/quiz-employee/send-answers', 'id' => $key],
                                                [
                                                    'title' => 'Відправити відповіді по e-mail',
                                                    'class' => 'btn btn-primary'
                                                ]) : '';
                                        },
                                    ],
                                ],
                            ],

                    ]) ?>
                    <?= LinkPager::widget(['pagination' => $dataProvider->pagination]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


