<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $periodicity_id   integer
 * @property $name             string
 */

class Periodicity extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%periodicity}}';
    }

}