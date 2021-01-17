<?php

namespace app\controllers;

use app\modules\quiz\models\QuizEmployee;
use app\modules\quiz\models\QuizEmployeeAnswer;
use yii\filters\AccessControl;
use yii\web\Controller;
use \Yii;

class SurveyController extends Controller
{
    public $layout = 'frontend';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($token = '')
    {
        $quiz_employee = QuizEmployee::findOne(['token' => $token]);

        if (!$quiz_employee) {
            return $this->render('error', [
                'error' => 'Опитування не знайдено!',
            ]);
        }

        $is_start_page = !$quiz_employee->start_date;
        $is_process_page = $quiz_employee->start_date && !$quiz_employee->end_date;
        $is_finish_page = !$is_start_page && !$is_process_page;

        return $this->render('index', [
            'token' => $token,
            'is_start_page' => $is_start_page,
            'is_process_page' => $is_process_page,
            'is_finish_page' => $is_finish_page,
            'quiz_employee' => $quiz_employee,
        ]);
    }

    public function actionStart($token = '')
    {
        $quiz_employee = QuizEmployee::findOne(['token' => $token]);

        if ($quiz_employee && !$quiz_employee->start_date) {
            $quiz_employee->start_date = time();
            $quiz_employee->save();
        }

        return $this->redirect( [ 'survey/index', 'token' => $token ] );
    }

    public function actionFinish($token = '')
    {
        $quiz_employee = QuizEmployee::findOne(['token' => $token]);

        if ($quiz_employee && $quiz_employee->start_date && !$quiz_employee->end_date) {
            $data = Yii::$app->request->isPost ? Yii::$app->request->post() : [];

            $correct_answers = [];
            foreach ($quiz_employee->quiz->quizQuestions as $question) {
                foreach ($question->quizAnswers as $answer) {
                    if ($answer->correct) {
                        $correct_answers[ $answer->quiz_question_id ][] = $answer->quiz_answer_id;
                    }
                }
            }

            $employee_answers = [];
            foreach (($data['questions'] ?? []) as $question_id => $question) {
                foreach (($question['answers'] ?? []) as $answer_id => $answer_value) {
                    if ($answer_value !== 'on') {
                        continue;
                    }

                    $question_id = intval($question_id);
                    $answer_id = intval($answer_id);

                    $employee_answers[ $question_id ][] = $answer_id;

                    $employee_answer = new QuizEmployeeAnswer();
                    $employee_answer->quiz_employee_id = $quiz_employee->quiz_employee_id;
                    $employee_answer->quiz_answer_id = $answer_id;
                    $employee_answer->save();
                }
            }

            $all_questions_count = count($correct_answers);
            $correct_questions_count = 0;
            foreach ($employee_answers as $question_id => $answers_ids) {
                $correct_answers_ids = $correct_answers[ $question_id ] ?? [];

                sort($correct_answers_ids);
                sort($answers_ids);

                if (!empty($correct_answers_ids) && json_encode($correct_answers_ids) === json_encode($answers_ids)) {
                    $correct_questions_count++;
                }
            }

            $score = ceil(100 * $correct_questions_count / $all_questions_count);

            $quiz_employee->passed = 1;
            $quiz_employee->end_date = time();
            $quiz_employee->score = $score;
            $quiz_employee->save();
        }

        return $this->redirect( [ 'survey/index', 'token' => $token ] );
    }
}