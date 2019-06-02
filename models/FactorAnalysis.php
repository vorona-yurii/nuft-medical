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

    /**
     * @param $factor_id
     * @return array
     */
    public static function getFactorAnalysis($factor_id)
    {
        $return = [];
        $factorAnalysis = self::findAll(['factor_id' => $factor_id]);
        foreach ($factorAnalysis as $factorAnalysis_item) {
            $return[] = $factorAnalysis_item->analysis_id;
        }

        return $return;
    }

}