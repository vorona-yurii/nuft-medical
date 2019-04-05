<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $profession_id   integer
 * @property $name            string
 * @property $code            string
 */

class Profession extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profession}}';
    }

}