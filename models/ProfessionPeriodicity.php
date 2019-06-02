<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $profession_periodicity_id   integer
 * @property $profession_id               integer
 * @property $periodicity_id              integer
 */

class ProfessionPeriodicity extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profession_periodicity}}';
    }

    /**
     * @param $profession_id
     * @return array
     */
    public static function getProfessionPeriodicity($profession_id)
    {
        $return = [];
        $professionPeriodicity = self::findAll(['profession_id' => $profession_id]);
        foreach ($professionPeriodicity as $professionPeriodicity_item) {
            $return[] = $professionPeriodicity_item->periodicity_id;
        }

        return $return;
    }

}