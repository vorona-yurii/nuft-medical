<?php
/**
 * @var $id integer
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = ($id ? 'Редагування' : 'Додавання' ). ' професії';

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
                                <?= $form->field( $model, 'name', ['options' => ['class' => 'col-xs-12 col-lg-6']])
                                    ->label( 'Назва' )->textInput(); ?>
                                <?= $form->field( $model, 'code', ['options' => ['class' => 'col-xs-12 col-lg-6']])
                                    ->label( 'Код' )->textInput(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>З'язані дані</h5>
                            <div class="ibox-tools">
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-12 col-lg-4 field-professionform-analysis">
                                    <label class="control-label">Аналізи</label>
                                    <?php echo \kartik\select2\Select2::widget([
                                        'name'    => 'ProfessionForm[analysis]',
                                        'value'   => \app\models\ProfessionAnalysis::getProfessionAnalysis($model->profession_id),
                                        'data'    => \app\models\Analysis::getAllAnalysis(),
                                        'options' => [
                                            'placeholder' => 'Виберіть аналізи',
                                            'multiple' => true
                                        ],
                                        'pluginOptions' => [
                                            'tags' => false,
                                            'maximumInputLength' => 10
                                        ],
                                    ]); ?>
                                </div>
                                <div class="col-xs-12 col-lg-4 field-professionform-doctor">
                                    <label class="control-label">Лікарі</label>
                                    <?php echo \kartik\select2\Select2::widget([
                                        'name'    => 'ProfessionForm[doctor]',
                                        'value'   => \app\models\ProfessionDoctor::getProfessionDoctor($model->profession_id),
                                        'data'    => \app\models\Doctor::getAllDoctors(),
                                        'options' => [
                                            'placeholder' => 'Виберіть лікарів',
                                            'multiple' => true
                                        ],
                                        'pluginOptions' => [
                                            'tags' => false,
                                            'maximumInputLength' => 10
                                        ],
                                    ]); ?>
                                </div>
                                <div class="col-xs-12 col-lg-4 field-professionform-periodicity">
                                    <label class="control-label">Період</label>
                                    <?php echo \kartik\select2\Select2::widget([
                                        'name'    => 'ProfessionForm[periodicity]',
                                        'value'   => \app\models\ProfessionPeriodicity::getProfessionPeriodicity($model->profession_id),
                                        'data'    => \app\models\Periodicity::getAllPeriodicity(),
                                        'options' => [
                                            'placeholder' => 'Виберіть період',
                                            'multiple' => false
                                        ],
                                        'pluginOptions' => [
                                            'tags' => false,
                                            'maximumInputLength' => 10
                                        ],
                                    ]); ?>
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
