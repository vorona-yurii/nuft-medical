<?php
/**
 * @var $this  yii\web\View
 * @var $form  yii\bootstrap\ActiveForm
 * @var $model app\models\forms\LoginForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вхід в систему';
?>
<div class="login-page">
    <div class="container">
        <div class="col-md-4 login-form-wrap">
            <img alt="image" class="img-circle" src="<?= \yii\helpers\Url::to( '@web/images/nuft-logo.png' ); ?>">
            <h1><?= 'Вхід в систему' ?></h1>

            <?php $form = ActiveForm::begin( [
                'id'          => 'login-form',
                'layout'      => 'horizontal',
                'fieldConfig' => [
                    'template'     => "{label}\n{input}{error}\n",
                    'labelOptions' => [ 'class' => 'control-label' ],
                ],
            ] ); ?>

            <?= $form->field( $model, 'email' )->label( 'Email' ) ?>

            <?= $form->field( $model, 'password' )->passwordInput()->label( 'Пароль' ) ?>

            <?= $form->field( $model, 'rememberMe' )->checkbox( [
                'template' => "{input} {label}{error}\n",
            ] )->label('Запам\'ятати мене'); ?>

            <div class="form-group">
                <?= Html::submitButton( 'Ввійти', [ 'class' => 'btn btn-primary col-md-12', 'name' => 'login-button' ] ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
