<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $factor_analysis_id   integer
 * @property $factor_id            integer
 * @property $analysis_id          integer
 */

class FactorAnalysis extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%factor_analysis}}';
    }

}