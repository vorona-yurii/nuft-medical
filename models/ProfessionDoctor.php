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

}