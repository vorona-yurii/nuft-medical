<?php

namespace app\modules\quiz\src\behavior;

use app\modules\quiz\models\QuizSubject;
use app\modules\quiz\models\QuizSubjectMap;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class QuizHandler extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'find',
            ActiveRecord::EVENT_AFTER_INSERT => 'after',
            ActiveRecord::EVENT_AFTER_UPDATE => 'after',
        ];
    }

    public function find()
    {
        if (!$this->owner->isNewRecord && $this->owner->quizSubjectMaps) {
            $this->owner->subjects = ArrayHelper::getColumn($this->owner->quizSubjectMaps, 'quiz_subject_id');
        }
    }

    public function after()
    {
        QuizSubjectMap::deleteAll(['quiz_id' => $this->owner->quiz_id]);

        if ($this->owner->subjects) {
            foreach ($this->owner->subjects as $quiz_subject) {
                $subject_map = new QuizSubjectMap();
                $subject_map->quiz_id = $this->owner->quiz_id;
                $subject_map->quiz_subject_id = $quiz_subject;
                $subject_map->save();
            }
        }
    }
}