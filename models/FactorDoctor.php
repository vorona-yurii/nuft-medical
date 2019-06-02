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

    /**
     * @param $factor_id
     * @return array
     */
    public static function getFactorDoctor($factor_id)
    {
        $return = [];
        $factorDoctors = self::findAll(['factor_id' => $factor_id]);
        foreach ($factorDoctors as $factorDoctor) {
            $return[] = $factorDoctor->doctor_id;
        }

        return $return;
    }

}