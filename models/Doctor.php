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

}