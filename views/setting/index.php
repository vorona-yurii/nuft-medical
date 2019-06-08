<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Налаштування';

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2><?= $this->title; ?></h2>
                </div>
            </div>

            <?php $form = ActiveForm::begin( [
                'id'      => 'edit',
                'options' => [ 'enctype' => 'multipart/form-data' ],
            ] ); ?>

            <div class="wrapper wrapper-content">
                <div class="ibox-content">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Налаштування відправки пошти</h5>
                            <div class="ibox-tools">
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <?= $form->field( $model, 'enable_email_file', [ 'options' => [ 'class' => 'form-group col-lg-12 col-xs-12' ] ] )
                                    ->dropDownList( ['0' => 'Ні', '1' => 'Так'], ['options' => [ \app\models\Setting::getSetting('enable_email_file') => ['selected' => true] ]]  )
                                    ->label('Прикріпляти до повідомлення файл направлення працівника?'); ?>
                                <?= $form->field( $model, 'template_email', [ 'options' => [ 'class' => 'form-group col-lg-12 col-xs-12' ] ] )
                                    ->textarea( [ 'value' => \app\models\Setting::getSetting('template_email'), 'rows' => 5 ] )
                                    ->label('Шаблон повідомнее про медогляд для працівників') ?>
                                <div class="form-group col-lg-12">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            Шаблони
                                        </div>
                                        <div class="panel-body">
                                            <p><b>Змінні, які доступні в тексті. Вставте код "{{...}}" в текст, щоб підтянути конкретну інформацію.</b></p>
                                            <p><code>{{name}}</code> - ПІБ працівника</p>
                                            <p><code>{{date}}</code> - дата проходження медогляду</p>
                                            <p><code>{{point}}</code> - місце проходження медогляду</p>
                                        </div>
                                    </div>
                                </div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
