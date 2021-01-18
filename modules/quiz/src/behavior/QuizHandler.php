<?php

namespace app\modules\quiz\src\behavior;

use app\modules\quiz\models\QuizAnswer;
use app\modules\quiz\models\QuizEmployee;
use app\modules\quiz\models\QuizQuestion;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use Yii;

class QuizHandler extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'find',
            ActiveRecord::EVENT_AFTER_INSERT => 'after',
            ActiveRecord::EVENT_AFTER_UPDATE => 'after',
        ];
    }

    public function find()
    {
        $this->owner->employees = !$this->owner->isNewRecord ? ArrayHelper::getColumn($this->owner->quizEmployees, 'employee_id') : [];
        if (!$this->owner->isNewRecord && $this->owner->quizQuestions) {
            foreach ($this->owner->quizQuestions as $question) {
                $quiz_question = [
                    'content' => $question->content,
                    'explanation' => $question->explanation,
                    'references' => $question->references
                ];
                if ($question->quizAnswers) {
                    foreach ($question->quizAnswers as $answer) {
                        $quiz_question['answers'][] = [
                            'content' => $answer->content,
                            'correct' => $answer->correct
                        ];
                    }
                }
                $this->owner->questions[] = $quiz_question;
            }
        }
    }

    public function after()
    {
        $this->employees();
        $this->questions();
    }

    private function employees()
    {
        $employees = [];
        if ($this->owner->employees) {
            foreach ($this->owner->employees as $employee_id) {
                if (!$quiz_employee = QuizEmployee::findOne(['quiz_id' => $this->owner->quiz_id, 'employee_id' => $employee_id])) {
                    $quiz_employee = new QuizEmployee();
                    $quiz_employee->quiz_id = $this->owner->quiz_id;
                    $quiz_employee->employee_id = $employee_id;
                    $quiz_employee->token = Yii::$app->security->generateRandomString(12);
                    $quiz_employee->save();
                }
                $employees[] = $quiz_employee->employee_id;
            }
        }
        QuizEmployee::deleteAll([
            'and',
            ['not', ['in', 'employee_id', $employees]],
            ['quiz_id' => $this->owner->quiz_id]
        ]);
    }

    private function questions()
    {
        QuizQuestion::deleteAll(['quiz_id' => $this->owner->quiz_id]);

        if ($this->owner->questions) {
            foreach ($this->owner->questions as $quiz_question) {
                $question = new QuizQuestion();
                $question->quiz_id = $this->owner->quiz_id;
                $question->type = QuizQuestion::TYPE_SIMPLE;
                $question->content = $quiz_question['content'];
                $question->explanation = $quiz_question['explanation'];
                $question->references = $quiz_question['references'];
                if ($question->save()) {
                    if (isset($quiz_question['answers']) && $quiz_question['answers']) {
                        $multiple = 0;
                        foreach ($quiz_question['answers'] as $quiz_answer) {
                            $answer = new QuizAnswer();
                            $answer->quiz_question_id = $question->quiz_question_id;
                            $answer->content = $quiz_answer['content'];
                            $answer->correct = $quiz_answer['correct'];
                            $answer->save();
                            if ($quiz_answer['correct']) {
                                $multiple += 1;
                            }
                        }
                        if ($multiple > 1) {
                            $question->type = QuizQuestion::TYPE_MULTIPLE;
                            $question->save();
                        }
                    }
                }
            }
        }
    }
}