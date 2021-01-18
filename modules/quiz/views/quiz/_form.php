<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Quiz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quiz-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'duration')->textInput(['type' => 'number']) ?>

    <hr>
    <p><b>Питання опитування</b></p>
    <?= $form->field($model, 'questions')->widget(MultipleInput::className(), [
        'min' => 0,
        'max' => 20,
        'iconSource' => 'fa',
        'columns' => [
            [
                'name' => 'content',
                'title' => 'Питання',
                'enableError' => true,
                'options' => [
                    'class' => 'input-priority'
                ]
            ],
            [
                'name' => 'explanation',
                'type' => 'textarea',
                'title' => 'Пояснення',
                'enableError' => true,
            ],
            [
                'name' => 'references',
                'type' => 'textarea',
                'title' => 'Ресурси',
                'enableError' => true,
            ],
            [
                'name' => 'answers',
                'type' => MultipleInput::className(),
                'title' => 'Відповіді',
                'options' => [
                    'min' => 0,
                    'max' => 5,
                    'columns' => [
                        [
                            'name' => 'content',
                            'title' => 'Назва',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                        [
                            'name' => 'correct',
                            'title' => 'Вірна',
                            'type' => 'checkbox',
                            'enableError' => true,
                        ],
                    ]
                ]
            ],
        ]
    ])->label(false); ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>