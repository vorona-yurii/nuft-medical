<?php

namespace app\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_employee_answer".
 *
 * @property int $quiz_employee_answer_id
 * @property int $quiz_employee_id
 * @property int $quiz_answer_id
 *
 * @property QuizAnswer $quizAnswer
 * @property QuizEmployee $quizEmployee
 */
class QuizEmployeeAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_employee_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_employee_id', 'quiz_answer_id'], 'integer'],
            [['quiz_answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizAnswer::className(), 'targetAttribute' => ['quiz_answer_id' => 'quiz_answer_id']],
            [['quiz_employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizEmployee::className(), 'targetAttribute' => ['quiz_employee_id' => 'quiz_employee_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_employee_answer_id' => 'Quiz Employee Answer ID',
            'quiz_employee_id' => 'Quiz Employee ID',
            'quiz_answer_id' => 'Quiz Answer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAnswer()
    {
        return $this->hasOne(QuizAnswer::className(), ['quiz_answer_id' => 'quiz_answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizEmployee()
    {
        return $this->hasOne(QuizEmployee::className(), ['quiz_employee_id' => 'quiz_employee_id']);
    }
}
