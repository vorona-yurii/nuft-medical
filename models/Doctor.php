<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $doctor_id   integer
 * @property $name        string
 */

class Doctor extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%doctor}}';
    }

    /**
     * @return array
     */
    public static function getAllDoctors()
    {
        $return[ null ] = 'Не вказано';

        $doctors = self::find()->all();
        foreach ($doctors as $doctor) {
            $return[$doctor->doctor_id] = $doctor->name;
        }

        return $return;
    }



}