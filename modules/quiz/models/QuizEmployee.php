<?php

namespace app\modules\quiz\models;

use app\models\Employee;
use app\modules\quiz\src\behavior\QuizEmployeeHandler;
use Yii;

/**
 * This is the model class for table "quiz_employee".
 *
 * @property int $quiz_employee_id
 * @property int $employee_id
 * @property int $quiz_id
 * @property string $token
 * @property int $passed
 * @property int $start_date
 * @property int $end_date
 * @property int $score
 *
 * @property Employee $employee
 * @property Quiz $quiz
 * @property QuizEmployeeAnswer[] $quizEmployeeAnswers
 */
class QuizEmployee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_employee';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => QuizEmployeeHandler::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'quiz_id', 'passed', 'start_date', 'end_date', 'score'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'employee_id']],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'quiz_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_employee_id' => 'ID опитування працівника',
            'employee_id' => 'Працівник',
            'quiz_id' => 'ID опитування',
            'token' => 'Посилання',
            'passed' => 'Пройшов опитування',
            'start_date' => 'Час початку',
            'end_date' => 'Час закінчення',
            'score' => 'Рахунок',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['employee_id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['quiz_id' => 'quiz_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizEmployeeAnswers()
    {
        return $this->hasMany(QuizEmployeeAnswer::className(), ['quiz_employee_id' => 'quiz_employee_id']);
    }

    public static function addEmployee($employee_id, $quiz_id)
    {
        if (!$quiz_employee = QuizEmployee::findOne(['quiz_id' => $quiz_id, 'employee_id' => $employee_id])) {
            $quiz_employee = new QuizEmployee();
            $quiz_employee->quiz_id = $quiz_id;
            $quiz_employee->employee_id = $employee_id;
            $quiz_employee->token = Yii::$app->security->generateRandomString(12);
            $quiz_employee->save();
        }
        return $quiz_employee;
    }
}
