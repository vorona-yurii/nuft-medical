<?php

namespace app\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_answer".
 *
 * @property int $quiz_answer_id
 * @property int $quiz_question_id
 * @property string $content
 * @property int $correct
 *
 * @property QuizQuestion $quizQuestion
 * @property QuizEmployeeAnswer[] $quizEmployeeAnswers
 */
class QuizAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_question_id', 'correct'], 'integer'],
            [['content'], 'string'],
            [['quiz_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizQuestion::className(), 'targetAttribute' => ['quiz_question_id' => 'quiz_question_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_answer_id' => 'Quiz Answer ID',
            'quiz_question_id' => 'Quiz Question ID',
            'content' => 'Content',
            'correct' => 'Correct',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestion()
    {
        return $this->hasOne(QuizQuestion::className(), ['quiz_question_id' => 'quiz_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizEmployeeAnswers()
    {
        return $this->hasMany(QuizEmployeeAnswer::className(), ['quiz_answer_id' => 'quiz_answer_id']);
    }
}
