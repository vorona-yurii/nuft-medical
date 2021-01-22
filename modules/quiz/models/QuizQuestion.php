<?php

namespace app\modules\quiz\models;

use app\modules\quiz\src\behavior\QuizQuestionHandler;
use Yii;

/**
 * This is the model class for table "quiz_question".
 *
 * @property int $quiz_question_id
 * @property int $quiz_subject_id
 * @property int $level
 * @property string $type
 * @property string $image
 * @property string $content
 * @property string $explanation
 * @property array $references
 *
 * @property QuizAnswer[] $quizAnswers
 * @property QuizSubject $quizSubject
 */
class QuizQuestion extends \yii\db\ActiveRecord
{
    const TYPE_SIMPLE = 'simple';
    const TYPE_MULTIPLE = 'multiple';

    public $media;
    public $answers;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_question';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => QuizQuestionHandler::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_subject_id', 'level'], 'integer'],
            [['type', 'content', 'explanation'], 'string'],
            [['level', 'quiz_subject_id', 'content', 'explanation'], 'required'],
            [['references', 'image', 'answers'], 'safe'],
            [['quiz_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizSubject::className(), 'targetAttribute' => ['quiz_subject_id' => 'quiz_subject_id']],
            [['media'], 'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 3, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_question_id' => 'ID питання',
            'quiz_subject_id' => 'Тема опитування',
            'level' => 'Рівень',
            'type' => 'Тип питання',
            'image' => 'Картинка',
            'media' => 'Картинка',
            'content' => 'Текст питання',
            'explanation' => 'Пояснення',
            'references' => 'Ресурси',
            'answers' => 'Відповіді'
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
    public function getQuizSubject()
    {
        return $this->hasOne(QuizSubject::className(), ['quiz_subject_id' => 'quiz_subject_id']);
    }
}
