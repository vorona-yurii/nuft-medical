<?php

namespace app\modules\quiz\src\behavior;

use app\modules\quiz\models\QuizAnswer;
use app\modules\quiz\models\QuizQuestion;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

class QuizQuestionHandler extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'find',
            ActiveRecord::EVENT_BEFORE_INSERT => 'before',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'before',
            ActiveRecord::EVENT_AFTER_INSERT => 'after',
            ActiveRecord::EVENT_AFTER_UPDATE => 'after',
        ];
    }

    public function find()
    {
        if (!$this->owner->isNewRecord && $this->owner->quizAnswers) {
            foreach ($this->owner->quizAnswers as $answer) {
                $this->owner->answers[] = [
                    'content' => $answer->content,
                    'correct' => $answer->correct
                ];
            }
        }
    }

    public function before()
    {
        if ($this->owner->media) {
            $filename = $this->upload($this->owner->media);
            if ($filename) {
                $this->owner->image = $filename;
            }
        }
    }

    public function after()
    {
        QuizAnswer::deleteAll(['quiz_question_id' => $this->owner->quiz_question_id]);

        if (isset($this->owner->answers) && $this->owner->answers) {
            $multiple = 0;
            foreach ($this->owner->answers as $quiz_answer) {
                $answer = new QuizAnswer();
                $answer->quiz_question_id = $this->owner->quiz_question_id;
                $answer->content = $quiz_answer['content'];
                $answer->correct = $quiz_answer['correct'];
                $answer->save();
                if ($quiz_answer['correct']) {
                    $multiple += 1;
                }
            }
            if ($multiple > 1) {
                $this->owner->type = QuizQuestion::TYPE_MULTIPLE;
                $this->owner->save();
            }
        }
    }

    /**
     * @param $file
     * @return string|null
     * @throws \yii\base\Exception
     */
    private function upload($file)
    {
        if (isset($file->name)) {
            $directory = \Yii::getAlias('uploads/question/');

            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }

            $pathFile = pathinfo(basename($file->name));
            $filename = $directory . time() . '_' . $pathFile['filename'] . '.' . $pathFile['extension'];
            if ($file->saveAs($filename)) {
                return $filename;
            }
        }
        return null;
    }
}
