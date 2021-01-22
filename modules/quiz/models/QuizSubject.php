<?php

namespace app\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_subject".
 *
 * @property int $quiz_subject_id
 * @property string $name
 *
 * @property QuizQuestion[] $quizQuestions
 * @property QuizSubjectMap[] $quizSubjectMaps
 * @property Quiz[] $quizzes
 */
class QuizSubject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            ['name', 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_subject_id' => 'Quiz Subject ID',
            'name' => 'Назва',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestions()
    {
        return $this->hasMany(QuizQuestion::className(), ['quiz_subject_id' => 'quiz_subject_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSubjectMaps()
    {
        return $this->hasMany(QuizSubjectMap::className(), ['quiz_subject_id' => 'quiz_subject_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizzes()
    {
        return $this->hasMany(Quiz::className(), ['quiz_id' => 'quiz_id'])->viaTable('quiz_subject_map', ['quiz_subject_id' => 'quiz_subject_id']);
    }
}
