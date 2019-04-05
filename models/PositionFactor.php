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

}