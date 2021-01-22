<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\modules\quiz\models\QuizSubject;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Quiz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quiz-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'duration')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'subjects')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(QuizSubject::find()->all(), 'quiz_subject_id', 'name'),
            'options' => [
                'placeholder' => 'Виберіть теми',
                'multiple' => true
            ],
        ])
    ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>