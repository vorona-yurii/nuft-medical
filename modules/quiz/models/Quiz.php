<?php

namespace app\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz".
 *
 * @property int $quiz_id
 * @property string $name
 * @property string $description
 * @property int $duration
 *
 * @property QuizEmployee[] $quizEmployees
 * @property QuizQuestion[] $quizQuestions
 */
class Quiz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['duration'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_id' => 'Quiz ID',
            'name' => 'Name',
            'description' => 'Description',
            'duration' => 'Duration',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizEmployees()
    {
        return $this->hasMany(QuizEmployee::className(), ['quiz_id' => 'quiz_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestions()
    {
        return $this->hasMany(QuizQuestion::className(), ['quiz_id' => 'quiz_id']);
    }
}
