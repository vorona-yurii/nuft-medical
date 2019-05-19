<?php
/**
 * @var $id integer
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Employee;

$this->title = ($id ? 'Редагування' : 'Додавання' ). ' працівника';

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
                                <?= $form->field( $model, 'full_name', ['options' => ['class' => 'col-xs-12 col-lg-6']])
                                    ->label( 'Прізвище, ім\'я, по батькові' )->textInput(); ?>
                                <?= $form->field( $model, 'phone', ['options' => ['class' => 'col-xs-12 col-lg-3']])
                                    ->label( 'Телефон' )->widget(\yii\widgets\MaskedInput::className(), [
                                        'mask' => '+38(099) 999-99-99'
                                    ]); ?>
                                <?= $form->field( $model, 'email', ['options' => ['class' => 'col-xs-12 col-lg-3']])
                                    ->label( 'Електронна пошта' )->textInput(); ?>
                            </div>
                            <div class="row">
                                <?= $form->field( $model, 'birth_date', ['options' => ['class' => 'col-xs-12 col-lg-3']])
                                    ->label( 'Дата народження ' )->widget(\dosamigos\datepicker\DatePicker::className(),[
                                        'name'    => 'birth_date',
                                        'options' => ['placeholder' => 'Виберіть дату'],
                                        'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'dd.mm.yyyy'
                                        ]
                                    ]); ?>
                                <?= $form->field( $model, 'residence', ['options' => ['class' => 'col-xs-12 col-lg-3']])
                                    ->label( 'Місце проживання ' )->textInput(); ?>
                                <?= $form->field( $model, 'gender', ['options' => ['class' => 'col-xs-12 col-lg-2']])
                                    ->label( 'Стать ' )->dropDownList( Employee::getGenderArray(),  [ 'options' => [ $model->gender => [ 'selected' => true ] ] ] ); ?>
                                <?= $form->field( $model, 'position_id', ['options' => ['class' => 'col-xs-12 col-lg-2']])
                                    ->label( 'Посада ' )->textInput(); ?>
                                <?= $form->field( $model, 'work_experience', ['options' => ['class' => 'col-xs-12 col-lg-2']])
                                    ->label( 'Стаж роботи ' )->textInput(); ?>
                            </div>
                            <div class="row">
                                <?= $form->field( $model, 'additional_info', ['options' => ['class' => 'col-xs-12 col-lg-12']])
                                    ->label( 'Додаткова інформація ' )->textarea(['rows' => 5]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Медичні дані</h5>
                            <div class="ibox-tools">
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <?= $form->field( $model, 'weight', ['options' => ['class' => 'col-xs-12 col-lg-2']])
                                    ->label( 'Вага ' )->textInput(); ?>
                                <?= $form->field( $model, 'height', ['options' => ['class' => 'col-xs-12 col-lg-2']])
                                    ->label( 'Зріст ' )->textInput(); ?>
                                <?= $form->field( $model, 'arterial_pressure', ['options' => ['class' => 'col-xs-12 col-lg-2']])
                                    ->label( 'Артеріальний тиск ' )->textInput(); ?>
                                <?= $form->field( $model, 'first_medical_examination_date', ['options' => ['class' => 'col-xs-12 col-lg-3']])
                                    ->label( 'Дата первинного медогляду ' )->widget(\dosamigos\datepicker\DatePicker::className(),[
                                        'name'    => 'first_medical_examination_date',
                                        'options' => ['placeholder' => 'Виберіть дату'],
                                        'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'dd.mm.yyyy'
                                        ]
                                    ]); ?>
                                <?= $form->field( $model, 'last_medical_examination_date', ['options' => ['class' => 'col-xs-12 col-lg-3']])
                                    ->label( 'Дата останнього медогляду ' )->widget(\dosamigos\datepicker\DatePicker::className(),[
                                        'name'    => 'last_medical_examination_date',
                                        'options' => ['placeholder' => 'Виберіть дату'],
                                        'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'dd.mm.yyyy'
                                        ]
                                    ]); ?>
                            </div>
                            <div class="row">
                                <?= $form->field( $model, 'medical_conclusion', ['options' => ['class' => 'col-xs-12 col-lg-12']])
                                    ->label( 'Висновок медогляду ' )->textarea(['rows' => 5]); ?>
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
