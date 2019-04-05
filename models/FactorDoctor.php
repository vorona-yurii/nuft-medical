<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $factor_doctor_id   integer
 * @property $factor_id          integer
 * @property $doctor_id          integer
 */

class FactorDoctor extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%factor_doctor}}';
    }

}