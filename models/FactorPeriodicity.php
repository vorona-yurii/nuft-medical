<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $factor_periodicity_id   integer
 * @property $factor_id               integer
 * @property $periodicity_id          integer
 */

class FactorPeriodicity extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%factor_periodicity}}';
    }

    /**
     * @param $factor_id
     * @return array
     */
    public static function getFactorPeriodicity($factor_id)
    {
        $return = [];
        $factorPeriodicity = self::findAll(['factor_id' => $factor_id]);
        foreach ($factorPeriodicity as $factorPeriodicity_item) {
            $return[] = $factorPeriodicity_item->periodicity_id;
        }

        return $return;
    }

}