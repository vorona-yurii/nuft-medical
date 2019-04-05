<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $profession_periodicity_id   integer
 * @property $profession_id               integer
 * @property $periodicity_id              integer
 */

class ProfessionPeriodicity extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profession_periodicity}}';
    }

}