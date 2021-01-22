<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\quiz\models\QuizSubject;
use yii\helpers\Url;
use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\QuizQuestion */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('
    $(".clear-image").click(function(e) {
        e.preventDefault();
        let that = $(this);
        let url = "' . Url::to(['/quiz/quiz-question/ajax-delete-image', 'id' => $model->quiz_question_id]) . '";
        $.post(url, function(data) {
            that.parent().parent().find("input").val("");
            that.parent().remove();
        });
    });
');
?>

<div class="quiz-question-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quiz_subject_id')->dropDownList(ArrayHelper::map(QuizSubject::find()->all(), 'quiz_subject_id', 'name'), ['prompt' => 'Виберіть тему']) ?>
    <?= $form->field($model, 'level')->dropDownList([1 => 1, 2 => 2, 3 => 3], ['prompt' => 'Виберіть рівень']) ?>

    <div class="wrap_image_main">
        <?php if ($model->image) { ?>
            <div class="image-main" style="margin-bottom: 20px;">
                <img src="/<?= Url::to($model->image); ?>" width="200" alt="">
                <br/><a href="#" class="clear-image">Видалити картинку</a>
            </div>
        <?php } ?>
        <?= $form->field($model, 'media')->fileInput() ?>
    </div>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'explanation')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'references')->textarea(['rows' => 6]) ?>

    <hr>
    <p><b>Відповіді</b></p>
    <?= $form->field($model, 'answers')->widget(MultipleInput::className(), [
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
    ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
