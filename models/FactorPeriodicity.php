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

}