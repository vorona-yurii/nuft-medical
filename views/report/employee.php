<?php

use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Звіти - Працівники';

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2><?= $this->title ?></h2>
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="ibox-content">
                    <?php Pjax::begin(); ?>

                    <?= GridView::widget( [
                        'filterModel'  => $searchModel,
                        'dataProvider' => $dataProvider,
                        'layout'       => '{items}',
                        'columns'      =>
                            [
                                'employee_id:integer:ID',
                                'full_name:text:ПІБ',
                                [
                                    'label'  => 'Дії',
                                    'format' => 'raw',
                                    'value'  => function ( $searchModel) {
                                        $buttons = '';

                                        $buttons .= '<div class="btn-group">' . Html::a(
                                            'Картка',
                                            Url::toRoute([
                                                "report/employee-medical-card/download",
                                                'employeeId' => $searchModel->employee_id
                                            ]),
                                            [
                                                'class' => 'btn btn-primary btn-edit-employee',
                                                'target'=>'_blank',
                                                'data-pjax' => '0'
                                            ]
                                        );

                                        $buttons .= '<div class="btn-group">' . Html::a(
                                            'Направлення',
                                            Url::toRoute([
                                                "report/employee-medical-referral/download",
                                                'employeeId' => $searchModel->employee_id
                                            ]),
                                            [
                                                'class' => 'btn btn-primary btn-edit-employee',
                                                'target'=>'_blank',
                                                'data-pjax' => '0'
                                            ]
                                        );

                                        return $buttons;
                                    },
                                    'contentOptions' => function () {
                                        return ['style' => 'text-align: center;'];
                                    },
                                ],
                            ],

                    ] ) ?>
                    <?= LinkPager::widget( [ 'pagination' => $dataProvider->pagination ] ); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
