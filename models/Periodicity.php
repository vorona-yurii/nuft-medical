<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $periodicity_id   integer
 * @property $name             string
 */

class Periodicity extends ActiveRecord
{
    private $reason = '';

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%periodicity}}';
    }
}