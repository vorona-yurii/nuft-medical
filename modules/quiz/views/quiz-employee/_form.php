<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Employee;
use app\models\Position;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\QuizEmployee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quiz-employee-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'quiz_id')->hiddenInput()->label(false); ?>

    <p><b>Працівникам</b></p>
    <?= $form->field($model, 'employees')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(Employee::find()->all(), 'employee_id', 'full_name'),
            'options' => [
                'placeholder' => 'Виберіть працівників',
                'multiple' => true
            ],
        ])->label(false);
    ?>

    <hr>
    <p><b>Підрозділи</b></p>
    <?= $form->field($model, 'positions')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(Position::find()->all(), 'position_id', 'name'),
            'options' => [
                'placeholder' => 'Виберіть підрозділи',
                'multiple' => true
            ],
        ])->label(false);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
