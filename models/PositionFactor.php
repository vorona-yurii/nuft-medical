<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $position_factor_id   integer
 * @property $position_id          integer
 * @property $factor_id            integer
 */

class PositionFactor extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%position_factor}}';
    }

    /**
     * @param $position_id
     * @return array
     */
    public static function getPositionFactors($position_id)
    {
        $return = [];
        $positionFactors = PositionFactor::findAll(['position_id' => $position_id]);
        foreach ($positionFactors as $positionFactor) {
            $return[] = $positionFactor->factor_id;
        }

        return $return;
    }

}