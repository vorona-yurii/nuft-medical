<?php

namespace app\modules\quiz\src\behavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\Url;

class QuizEmployeeHandler extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'after',
        ];
    }

    public function after()
    {
        $subjects = [];
        foreach ($this->owner->quiz->quizSubjectMaps as $map) {
            $subjects[] = $map->quizSubject->name;
        }
        $text = '<p>Доброго дня!</p> <p>Вам вислано посилання на проходження опитування на теми (<b>' . implode(',', $subjects) . '</b>).</p>';
        $text .= '<p>Натисніть на <a href="' . Url::to(['/survey/index', 'token' => $this->owner->token], true) . '">посилання</a>, щоб перейти до опитування.</p>';
        Yii::$app->mailer->compose()
            ->setFrom('yuvsender@gmail.com')
            ->setTo($this->owner->employee->email)
            ->setSubject('Опитування')
            ->setTextBody(strip_tags($text))
            ->setHtmlBody($text)
            ->send();
    }
}