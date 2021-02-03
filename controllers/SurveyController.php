<?php

namespace app\controllers;

use app\modules\quiz\models\QuizEmployee;
use app\modules\quiz\models\QuizEmployeeAnswer;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\Controller;
use \Yii;

class SurveyController extends Controller
{
    const MAX_QUESTIONS_COUNT = 5;
    const MIN_LEVEL = 1;
    const MAX_LEVEL = 3;


    public $layout = 'frontend';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['index', 'start', 'finish', 'explanation'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    private function renderQuizPage($params)
    {
        $params += [
            'quiz_employee' => null,

            'is_start_page' => false,
            'is_process_page' => false,
            'is_finish_page' => false,
            'is_explanation_page' => false,
        ];

        if ($params['is_process_page']) {
            $params['questions'] = $this->getCurrentQuizQuestions($params['quiz_employee']);
        } elseif ($params['is_explanation_page']) {
            $params['questions'] = $this->getAllQuizQuestions($params['quiz_employee']);
        } else {
            $params['questions'] = [];
        }

        $params['token'] = $params['quiz_employee']->token;
        $params['current_level'] = $params['quiz_employee']->current_level;
        $params['max_level'] = self::MAX_LEVEL;

        return $this->render('index', $params);
    }

    public function actionIndex($token = '')
    {
        $quiz_employee = QuizEmployee::findOne(['token' => $token]);

        if (!$quiz_employee) {
            return $this->render('error', [
                'error' => 'Опитування не знайдено!',
            ]);
        }

        $params = [
            'quiz_employee' => $quiz_employee,
        ];

        if (!$quiz_employee->start_date) {
            $params['is_start_page'] = true;
        } elseif ($quiz_employee->start_date && !$quiz_employee->end_date) {
            $params['is_process_page'] = true;
        } else {
            $params['is_finish_page'] = true;
        }

        return $this->renderQuizPage($params);
    }

    public function actionExplanation($token = '')
    {
        $quiz_employee = QuizEmployee::findOne(['token' => $token]);

        if (!$quiz_employee || !$quiz_employee->passed || (Yii::$app->user->isGuest && !$quiz_employee->show_explanation)) {
            return $this->render('error', [
                'error' => 'Опитування не знайдено!',
            ]);
        }

        $params = [
            'quiz_employee' => $quiz_employee,
            'is_explanation_page' => true,
        ];

        return $this->renderQuizPage($params);
    }

    public function actionStart($token = '')
    {
        $quiz_employee = QuizEmployee::findOne(['token' => $token]);

        if ($quiz_employee && !$quiz_employee->start_date) {
            $quiz_employee->start_date = time();
            $quiz_employee->save();
        }

        return $this->redirect(['survey/index', 'token' => $token]);
    }

    public function actionFinish($token = '')
    {
        $quiz_employee = QuizEmployee::findOne(['token' => $token]);

        if ($quiz_employee && $quiz_employee->start_date && !$quiz_employee->end_date) {
            $data = Yii::$app->request->isPost ? Yii::$app->request->post() : [];

            foreach (($data['questions'] ?? []) as $question_id => $question) {
                foreach (($question['answers'] ?? []) as $answer_id => $answer_value) {
                    if ($answer_value !== 'on') {
                        continue;
                    }

                    $employee_answer = new QuizEmployeeAnswer();
                    $employee_answer->quiz_employee_id = $quiz_employee->quiz_employee_id;
                    $employee_answer->quiz_answer_id = intval($answer_id);
                    $employee_answer->save();
                }
            }

            if ($quiz_employee->current_level >= self::MAX_LEVEL) {
                $quiz_employee->passed = 1;
                $quiz_employee->end_date = time();
                $quiz_employee->score = $this->getQuizScore($quiz_employee);
            } else {
                $quiz_employee->current_level = $quiz_employee->current_level + 1;
            }

            $quiz_employee->save();
        }

        return $this->redirect(['survey/index', 'token' => $token]);
    }

    private function getCurrentQuizQuestions($quiz_employee)
    {
        return $this->getQuizQuestions($quiz_employee, $quiz_employee->current_level);
    }

    private function getAllQuizQuestions($quiz_employee)
    {
        $questions = [];
        for ($level = self::MIN_LEVEL; $level <= self::MAX_LEVEL; $level++) {
            $levelQuestions = $this->getQuizQuestions($quiz_employee, $level);
            $questions = array_merge($questions, $levelQuestions);
        }

        return $questions;
    }

    private function getQuizScore($quiz_employee)
    {
        $questions = $this->getAllQuizQuestions($quiz_employee);

        $max_mark = 0;
        $mark = 0;

        foreach ($questions as $question) {
            $question_mark = $question->level;

            $max_mark += $question_mark;

            if ($question->correct) {
                $mark += $question_mark;
            }
        }

        $score = ceil((100 * $mark) / $max_mark);

        return $score;
    }

    private function getNumberHash($string)
    {
        $bin_hash = md5($string, true);
        $num_hash_parts = unpack('N2', $bin_hash);
        $num_hash = $num_hash_parts[1] . $num_hash_parts[2];

        return (string)$num_hash;
    }

    private function getQuizQuestions($quiz_employee, $level)
    {
        $hash_key = 'quiz_employee_' . $quiz_employee->quiz_employee_id . '_' . $level;
        $hash = $this->getNumberHash($hash_key);
        $hash_numbers = array_unique(str_split($hash));

        $employee_selected_answers_ids = [];
        foreach ($quiz_employee->quizEmployeeAnswers as $answer) {
            $employee_selected_answers_ids[] = $answer->quiz_answer_id;
        }

        $questions = [];
        foreach ($quiz_employee->quiz->quizSubjectMaps as $subject_map) {
            foreach ($subject_map->quizSubject->quizQuestions as $question) {
                if ($question->level != $level) {
                    continue;
                }

                $subject = $question->quizSubject->name;
                $is_question_correct = true;

                $answers = [];
                foreach ($question->quizAnswers as $answer) {
                    $answer = (object)ArrayHelper::toArray($answer);
                    $answer->selected = in_array($answer->quiz_answer_id, $employee_selected_answers_ids);

                    if ($answer->selected && !$answer->correct) {
                        $is_question_correct = false;
                    }
                    if (!$answer->selected && $answer->correct) {
                        $is_question_correct = false;
                    }

                    $answers[] = $answer;
                }
                shuffle($answers);

                $question = (object)ArrayHelper::toArray($question);
                $question->answers = $answers;
                $question->subject = $subject;
                $question->correct = $is_question_correct;

                if (!empty($hash_numbers)) {
                    $index = intval(array_shift($hash_numbers));
                    $questions[$index] = $question;
                } else {
                    $questions[] = $question;
                }
            }
        }

        ksort($questions);

        return array_slice($questions, 0, self::MAX_QUESTIONS_COUNT);
    }
}