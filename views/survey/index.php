<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$quiz = $quiz_employee->quiz;
$employee = $quiz_employee->employee;

$this->title = $quiz->name;

$this->registerCssFile('/css/quiz.css');

$register_navigation = $is_process_page || $is_explanation_page;
$register_timer = $is_process_page;
$register_answer_inputs = $is_process_page;

if ($register_navigation) {
    $this->registerJs('
        const minimumIdx = 0;
        const maximumIdx = $(".quiz-question").length - 1;
        let currentIdx = minimumIdx;

        function showQuestion(questionIdx) {
            if (questionIdx < minimumIdx) {
                questionIdx = minimumIdx;
            }
            if (questionIdx > maximumIdx) {
                questionIdx = maximumIdx;
            }
            currentIdx = questionIdx;

            const $question = $(`.quiz-question[data-idx=${questionIdx}]`);
            $(".quiz-question").hide();
            $question.show();

            const $mapButton = $(`.quiz-map-btn[data-idx=${questionIdx}]`);
            $(".quiz-map-btn").removeClass("active");
            $mapButton.addClass("active");

            const $prevButton = $(".quiz-prev-btn");
            $prevButton.removeClass("disabled");
            if (currentIdx === minimumIdx) {
                $prevButton.addClass("disabled");
            }

            const $nextButton = $(".quiz-next-btn");
            $nextButton.removeClass("disabled");
            if (currentIdx === maximumIdx) {
                $nextButton.addClass("disabled");
            }
        }

        function showNextQuestion() {
            showQuestion(currentIdx + 1);
        }

        function showPrevQuestion() {
            showQuestion(currentIdx - 1);
        }


        $(".quiz-next-btn").click(() => {
            showNextQuestion();
        });

        $(".quiz-prev-btn").click(() => {
            showPrevQuestion();
        });

        $(".quiz-map-btn").click(function() {
            const questionIdx = Number( $(this).attr("data-idx") );
            showQuestion(questionIdx);
        });

        showQuestion(currentIdx);
    ');
}

if ($register_timer) {
    $this->registerJs('
        const durationMinutes = Number('.$quiz->duration.');
        const startTimeSeconds = Number('.$quiz_employee->start_date.');

        let intervalId = null;

        if (durationMinutes) {
            const durationSeconds = durationMinutes * 60;
            const endTimeSeconds = startTimeSeconds + durationSeconds;

            intervalId = setInterval(() => {
                handleTimer(endTimeSeconds);
            }, 1000);

            handleTimer(endTimeSeconds);
        }

        function handleTimer(goalTimeSeconds) {
            const currentTimeSeconds = parseInt(new Date().getTime() / 1000);
            let leftTimeSeconds = goalTimeSeconds - currentTimeSeconds;

            if (leftTimeSeconds < 0) {
                leftTimeSeconds = 0;
            }

            const leftTimeFormatted = new Date(leftTimeSeconds * 1000).toISOString().substr(11, 8);
            $(".quiz-timer-label").text(leftTimeFormatted);

            if (!leftTimeSeconds) {
                clearInterval(intervalId);
                $("form#process").submit();
            }
        }

        $(".quiz-confirm-submit-btn").click(() => {
            $("form#process").submit();
        });

        $(".quiz-timer-box").show();
        $(".quiz-submit-box").show();
    ');
}

if ($register_answer_inputs) {
    $this->registerJs('
        $(".answer-input").click(function () {
            const $input = $(this);
            const $question = $input.closest(".quiz-question");

            if ($input.hasClass("answer-radio")) {
                $(".answer-radio", $question).prop("checked", false);
                $input.prop("checked", true);
            }

            const hasCheckedAnswer = Boolean($(".answer-input:checked", $question).length);

            const questionIdx = $question.attr("data-idx");
            const $mapButton = $(`.quiz-map-btn[data-idx=${questionIdx}]`);

            if (hasCheckedAnswer) {
                $mapButton.addClass("completed");
            } else {
                $mapButton.removeClass("completed");
            }
        });
    ');
}

?>

<div class="container quiz-container">
    <div class="col-md-10 col-md-offset-1 panel panel-primary">
        <div class="quiz-heading row panel-heading">
            <div class="col-md-12 text-center">
                <h2><?= $this->title ?></h2>
                <h3><?= $employee->full_name ?></h3>

                <?php
                    $levels_names = [
                        1 => 'початковий',
                        2 => 'достатній',
                        3 => 'високий',
                    ];
                ?>
            </div>
        </div>
        <div class="quiz-body row panel-body">
            <?php if ($is_start_page): ?>
                <?php
                    $form = ActiveForm::begin([
                        'id' => 'start',
                        'action' => Url::toRoute( [ 'survey/start', 'token' => $token ] ),
                        'options' => [ 'enctype' => 'multipart/form-data' ],
                    ]);
                ?>

                <div class="col-md-10 col-md-offset-1">
                    <?php if ($quiz->description): ?>
                        <div class="row text-justify">
                            <h4><?= $quiz->description ?></h4>
                        </div>
                    <?php endif; ?>
                    <br>
                    <div class="row text-center">
                        <?= Html::submitButton(
                            'Розпочати опитування',
                            [ 'class' => 'btn btn-lg btn-primary' ]
                        ) ?>
                    </div>
                    <br>
                    <?php if ($quiz->duration): ?>
                        <div class="row text-center">
                            <h4>Обмеження за часом - <?= $quiz->duration ?> хвилин</h4>
                        </div>
                    <?php endif; ?>
                </div>

                <?php ActiveForm::end(); ?>
            <?php endif; ?>

            <?php if ($is_process_page || $is_explanation_page): ?>
                <?php
                    $form = ActiveForm::begin([
                        'id' => 'process',
                        'action' => Url::toRoute( [ 'survey/finish', 'token' => $token ] ),
                        'options' => [ 'enctype' => 'multipart/form-data' ],
                    ]);
                ?>

                <div class="col-md-8">
                    <?php foreach ($questions as $idx => $question): ?>
                        <div class="quiz-question" data-idx="<?= $idx ?>">
                            <?php if ($question->image): ?>
                                <div class="question-image">
                                    <img src="/<?= Url::to($question->image); ?>">
                                </div>
                            <?php endif; ?>

                            <p class="text-justify"><?= $question->content ?></p>
                            <br>

                            <?php if ($is_process_page): ?>
                                <?php if ($question->type === 'simple'): ?>
                                    <span class="text-muted">Оберіть одну правильну відповідь:</span>
                                <?php endif; ?>
                                <?php if ($question->type === 'multiple'): ?>
                                    <span class="text-muted">Оберіть одну або декілька правильних відповідей:</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php foreach ($question->answers as $answer): ?>
                                <?php
                                    $answer_input_name = (
                                        "questions[$answer->quiz_question_id][answers][$answer->quiz_answer_id]"
                                    );

                                    $answer_content_class = '';
                                    $answer_checked_attr = '';
                                    if ($is_explanation_page) {
                                        if ($answer->selected) {
                                            $answer_checked_attr = 'checked';
                                        }

                                        if ($answer->correct) {
                                            $answer_content_class = 'bg-success';
                                        } elseif ($answer->selected) {
                                            $answer_content_class = 'bg-danger';
                                        }
                                    }
                                ?>
                                <?php if ($question->type === 'simple'): ?>
                                    <div class="radio">
                                        <label class="text-justify answer-radio-container">
                                            <input
                                                class="answer-input answer-radio"
                                                type="radio"
                                                name="<?= $answer_input_name ?>"
                                                <?= $answer_checked_attr ?>
                                            >
                                            <span class="checkmark"></span>
                                            <span class="answer-content <?= $answer_content_class ?>">
                                                <?= $answer->content ?>
                                            </span>
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <?php if ($question->type === 'multiple'): ?>
                                    <div class="checkbox">
                                        <label class="text-justify answer-checkbox-container">
                                            <input
                                                class="answer-input answer-checkbox"
                                                type="checkbox"
                                                name="<?= $answer_input_name ?>"
                                                <?= $answer_checked_attr ?>
                                            >
                                            <span class="checkmark"></span>
                                            <span class="answer-content <?= $answer_content_class ?>">
                                                <?= $answer->content ?>
                                            </span>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php if ($is_explanation_page && $question->explanation): ?>
                                <br>
                                <span class="text-muted">Пояснення:</span>
                                <p class="text-justify"><?= $question->explanation ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <br>
                    <div class="text-center">
                        <button type="button" class="quiz-prev-btn btn btn-lg btn-primary">Попереднє</button>
                        <button type="button" class="quiz-next-btn btn btn-lg btn-primary">Наступне</button>
                    </div>
                </div>
                <div class="quiz-sidebar col-md-4">
                    <div class="quiz-map-box">
                        <?php foreach ($questions as $idx => $question): ?>
                            <?php
                                $correct_class = '';
                                if ($is_explanation_page) {
                                    $correct_class = $question->correct ? 'correct' : 'incorrect';
                                }
                            ?>

                            <div class="quiz-map-btn <?= $correct_class ?>" data-idx="<?= $idx ?>">
                                <?= $idx + 1 ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="quiz-timer-box">
                        <span class="quiz-timer-label"></span>
                    </div>
                    <div class="quiz-submit-box text-center">
                        <button
                            type="button"
                            class="quiz-submit-btn btn btn-lg btn-success"
                            data-toggle="modal"
                            data-target="#confirm-finish-modal"
                        >
                        <?php if ($current_level < $max_level): ?>
                            Перейти до наступного рівня питань
                        <?php else: ?>
                            Завершити
                        <?php endif; ?>
                        </button>
                    </div>
                </div>

                <div id="confirm-finish-modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body text-center">
                                <h4 class="confirm-modal-message">
                                <?php if ($current_level < $max_level): ?>
                                    Ви дійсно бажаєте перейти до наступного рівня питань?
                                <?php else: ?>
                                    Ви дійсно бажаєте завершити опитування?
                                <?php endif; ?>
                                </h4>
                            </div>
                            <div class="modal-footer confirm-modal-buttons-box">
                                <button
                                    type="button"
                                    class="quiz-confirm-submit-btn btn btn-lg btn-success"
                                    data-dismiss="modal"
                                >Так</button>
                                <button
                                    type="button"
                                    class="btn btn-lg btn-danger"
                                    data-dismiss="modal"
                                >Ні</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            <?php endif; ?>

            <?php if ($is_finish_page): ?>
                <div class="col-md-10 col-md-offset-1">
                    <?php if ($quiz->description): ?>
                        <div class="row text-justify">
                            <h4><?= $quiz->description ?></h4>
                        </div>
                    <?php endif; ?>
                    <br>
                    <div class="alert alert-success text-center">
                        <h3>Опитування завершено!</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
