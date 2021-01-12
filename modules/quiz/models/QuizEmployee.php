<?php

namespace app\modules\quiz\models;

use app\models\Employee;
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
            'quiz_employee_id' => 'Quiz Employee ID',
            'employee_id' => 'Employee ID',
            'quiz_id' => 'Quiz ID',
            'token' => 'Token',
            'passed' => 'Passed',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'score' => 'Score',
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
}
