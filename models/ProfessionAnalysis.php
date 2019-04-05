<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $profession_analysis_id   integer
 * @property $profession_id            integer
 * @property $analysis_id              integer
 */

class ProfessionAnalysis extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profession_analysis}}';
    }

}