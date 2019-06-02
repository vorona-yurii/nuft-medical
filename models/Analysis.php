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

    /**
     * @return array
     */
    public static function getAllAnalysis()
    {
        $return[ null ] = 'Не вказано';

        $analysis = self::find()->all();
        foreach ($analysis as $analysis_item) {
            $return[$analysis_item->analysis_id] = $analysis_item->name;
        }

        return $return;
    }

}