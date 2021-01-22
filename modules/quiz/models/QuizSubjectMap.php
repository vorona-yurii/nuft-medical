<?php

namespace app\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_subject_map".
 *
 * @property int $quiz_id
 * @property int $quiz_subject_id
 *
 * @property Quiz $quiz
 * @property QuizSubject $quizSubject
 */
class QuizSubjectMap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_subject_map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'quiz_subject_id'], 'required'],
            [['quiz_id', 'quiz_subject_id'], 'integer'],
            [['quiz_id', 'quiz_subject_id'], 'unique', 'targetAttribute' => ['quiz_id', 'quiz_subject_id']],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'quiz_id']],
            [['quiz_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizSubject::className(), 'targetAttribute' => ['quiz_subject_id' => 'quiz_subject_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_id' => 'Quiz ID',
            'quiz_subject_id' => 'Quiz Subject ID',
        ];
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
    public function getQuizSubject()
    {
        return $this->hasOne(QuizSubject::className(), ['quiz_subject_id' => 'quiz_subject_id']);
    }
}
