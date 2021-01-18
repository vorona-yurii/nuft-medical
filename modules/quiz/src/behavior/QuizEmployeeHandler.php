<?php

namespace app\modules\quiz\src\behavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;

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
        // send to email employee
    }
}