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

}