<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\quiz\models\search\Quiz */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Опитування';
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
                            <a href="<?= Url::to(['/quiz/quiz/create']) ?>" class="btn btn-primary dim" type="button"><i
                                        class="fa fa-plus"></i> Додати опитування</a>
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
                                'name',
                                'description:ntext',
                                [
                                    'attribute' => 'duration',
                                    'value' => function ($data) {
                                        return $data->duration . ' хв';
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{update} {delete}',
                                    'headerOptions' => ['width' => '105'],
                                    'buttons' => [
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<i class="fa fa-pencil"></i>', ['/quiz/quiz/update', 'id' => $key],
                                                [
                                                    'class' => 'btn btn-primary',
                                                    'title' => 'Змінити',
                                                ]);
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            return Html::a('<i class="fa fa-trash"></i>', ['/quiz/quiz/delete', 'id' => $key],
                                                [
                                                    'title' => 'Видалити',
                                                    'class' => 'btn btn-danger',
                                                    'data-method' => 'post',
                                                    'data-pjax' => '0',
                                                    'data-confirm' => 'Ви впевнені, що хочете видалити це опитування?'
                                                ]);
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

