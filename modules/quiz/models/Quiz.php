<?php

namespace app\modules\quiz\models;

use app\modules\quiz\src\behavior\QuizHandler;
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
 * @property QuizSubjectMap[] $quizSubjectMaps
 */
class Quiz extends \yii\db\ActiveRecord
{
    public $subjects;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => QuizHandler::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['description', 'duration', 'name'], 'required'],
            [['subjects'], 'safe'],
            [['duration'], 'compare', 'compareValue' => 1, 'operator' => '>=', 'type' => 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_id' => '№ опитування',
            'name' => 'Назва',
            'description' => 'Опис',
            'duration' => 'Тривалість (хв)',
            'subjects' => 'Теми'
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
    public function getQuizSubjectMaps()
    {
        return $this->hasMany(QuizSubjectMap::className(), ['quiz_id' => 'quiz_id']);
    }
}
