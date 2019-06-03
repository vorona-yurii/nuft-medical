<?php
/**
 * @var $id integer
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Додавання списку груп';

?>
<style>
    .item-group button {
        margin-top: 23px;
    }
</style>

<?php $form = ActiveForm::begin( [
    'id'         => 'edit',
    'options'    => [ 'enctype' => 'multipart/form-data' ],
] ); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2><?= $this->title; ?></h2>
                </div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="ibox-content">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Основні дані</h5>
                            <div class="ibox-tools">
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <?= $form->field( $model, 'name', ['options' => ['class' => 'col-xs-12 col-lg-12']])
                                    ->label( 'Назва' )->textInput(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>З'язані дані (групи)</h5>
                            <div class="ibox-tools"></div>
                        </div>
                        <div class="ibox-content group-wrap">

                            <?= $form->field($model, 'report_group')->widget(\unclead\multipleinput\MultipleInput::className(), [
                                'columns' => [
                                    [
                                        'name'  => 'date_medical_check',
                                        'type'  => \kartik\date\DatePicker::className(),
                                        'title' => 'Дата проходження медогляду',
                                        'options' => [
                                            'pluginOptions' => [
                                                'format' => 'dd.mm.yyyy',
                                                'todayHighlight' => true
                                            ]
                                        ],
                                    ],
                                    [
                                        'name'    => 'department',
                                        'type'    => \kartik\select2\Select2::className(),
                                        'title'   => 'Підрозділи',
                                        'options' => [
                                            'pluginOptions' => [
                                                'placeholder' => 'Виберіть підрозділи',
                                                'multiple' => true
                                            ],
                                            'data' => \app\models\Department::getAllDepartments(),
                                        ],
                                    ],
                                    [
                                        'name'    => 'employee',
                                        'type'    => \kartik\select2\Select2::className(),
                                        'title'   => 'Працівники',
                                        'options' => [
                                            'pluginOptions' => [
                                                'placeholder' => 'Виберіть працівників',
                                                'multiple' => true
                                            ],
                                            'data' => \app\models\Employee::getAllEmployees(),
                                        ],
                                    ],
                                ]
                            ])->label(false); ?>

                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="form-horizontal">
                        <div class="form-group" style="margin: 0;">
                            <div class="col-xs-6">
                                <div class="col-md-3 col-sm-6">
                                    <?= Html::submitButton( 'Зберегти',
                                        [ 'class' => 'btn btn-primary', 'name' => 'save-edit' ] ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>