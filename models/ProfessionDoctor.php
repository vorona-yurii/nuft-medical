<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $profession_doctor_id   integer
 * @property $profession_id          integer
 * @property $doctor_id              integer
 */

class ProfessionDoctor extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profession_doctor}}';
    }

    /**
     * @param $profession_id
     * @return array
     */
    public static function getProfessionDoctor($profession_id)
    {
        $return = [];
        $professionDoctors = self::findAll(['profession_id' => $profession_id]);
        foreach ($professionDoctors as $professionDoctor) {
            $return[] = $professionDoctor->doctor_id;
        }

        return $return;
    }

}