<?php

namespace app\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_question".
 *
 * @property int $quiz_question_id
 * @property int $quiz_id
 * @property string $type
 * @property string $content
 * @property string $explanation
 * @property array $references
 *
 * @property QuizAnswer[] $quizAnswers
 * @property Quiz $quiz
 */
class QuizQuestion extends \yii\db\ActiveRecord
{
    const TYPE_SIMPLE = 'simple';
    const TYPE_MULTIPLE = 'multiple';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id'], 'integer'],
            [['type', 'content', 'explanation'], 'string'],
            [['references'], 'safe'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'quiz_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_question_id' => 'ID питання',
            'quiz_id' => 'ID опитування',
            'type' => 'Тип питання',
            'content' => 'Контент',
            'explanation' => 'Пояснення',
            'references' => 'Додаткові дані',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAnswers()
    {
        return $this->hasMany(QuizAnswer::className(), ['quiz_question_id' => 'quiz_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['quiz_id' => 'quiz_id']);
    }
}
