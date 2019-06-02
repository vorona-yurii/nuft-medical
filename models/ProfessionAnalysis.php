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

    /**
     * @param $profession_id
     * @return array
     */
    public static function getProfessionAnalysis($profession_id)
    {
        $return = [];
        $professionAnalysis = self::findAll(['profession_id' => $profession_id]);
        foreach ($professionAnalysis as $professionAnalysis_item) {
            $return[] = $professionAnalysis_item->analysis_id;
        }

        return $return;
    }

}