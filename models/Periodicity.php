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

    /**
     * @return array
     */
    public static function getAllPeriodicity()
    {
        $return[ null ] = 'Не вказано';

        $periodicity = self::find()->all();
        foreach ($periodicity as $periodicity_item) {
            $return[$periodicity_item->periodicity_id] = $periodicity_item->name;
        }

        return $return;
    }
}
