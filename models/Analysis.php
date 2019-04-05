<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $analysis_id   integer
 * @property $name          string
 */

class Analysis extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%analysis}}';
    }

}