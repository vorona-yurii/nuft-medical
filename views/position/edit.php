<?php
/**
 * @var $id integer
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = ($id ? 'Редагування' : 'Додавання' ). ' посади';

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2><?= $this->title; ?></h2>
                </div>
                <div class="col-sm-8">
                    <div class="btn-save-wrapp">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <?php $form = ActiveForm::begin( [
                                    'id'      => 'edit',
                                    'options' => [ 'enctype' => 'multipart/form-data' ],
                                ] ); ?>
                            </div>
                        </div>
                    </div>
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
                                <?= $form->field( $model, 'name', ['options' => ['class' => 'col-xs-12 col-lg-4']])
                                    ->label( 'Назва' )->textInput(); ?>
                                <div class="col-xs-12 col-lg-4 field-positionform-department_id">
                                    <label class="control-label" for="positionform-department_id">Підрозділ</label>
                                    <?php echo \kartik\select2\Select2::widget([
                                        'id'      => "positionform-department_id",
                                        'name'    => 'PositionForm[department_id]',
                                        'value'   => $model->department_id,
                                        'data'    => \app\models\Department::getAllDepartments(),
                                        'options' => [
                                            'placeholder' => 'Виберіть підрозділ',
                                            'multiple' => false
                                        ],
                                        'pluginOptions' => [
                                            'tags' => false,
                                            'maximumInputLength' => 10
                                        ],
                                    ]); ?>
                                </div>
                                <div class="col-xs-12 col-lg-4 field-positionform-profession_id">
                                    <label class="control-label" for="positionform-profession_id">Професія</label>
                                    <?php echo \kartik\select2\Select2::widget([
                                        'id'      => "positionform-profession_id",
                                        'name'    => 'PositionForm[profession_id]',
                                        'value'   => $model->profession_id,
                                        'data'    => \app\models\Profession::getAllProfessions(),
                                        'options' => [
                                            'placeholder' => 'Виберіть професію',
                                            'multiple' => false
                                        ],
                                        'pluginOptions' => [
                                            'tags' => false,
                                            'maximumInputLength' => 10
                                        ],
                                    ]); ?>
                                </div>
                            </div>
                            <div class="row">
                                <?= $form->field( $model, 'additional_info', ['options' => ['class' => 'col-xs-12 col-lg-12']])
                                    ->label( 'Додаткова інформація' )->textarea(['rows' => 5]); ?>
                            </div>
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
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
