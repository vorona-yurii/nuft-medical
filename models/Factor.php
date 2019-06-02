<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $factor_id   integer
 * @property $name        string
 * @property $code        string
 */

class Factor extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%factor}}';
    }

    /**
     * @return array
     */
    public static function getAllFactors()
    {
        $return[ null ] = 'Не вказано';

        $factors = self::find()->all();
        foreach ($factors as $factor) {
            $return[$factor->factor_id] = $factor->name;
        }

        return $return;
    }

}