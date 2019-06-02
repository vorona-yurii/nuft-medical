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

    public function getCombinedName()
    {
        return $this->name.' ('.$this->code.')';
    }

    /**
     * @return array
     */
    public static function getAllProfessions()
    {
        $return[ null ] = 'Не вказано';

        $professions = self::find()->all();
        foreach ($professions as $profession) {
            $return[$profession->profession_id] = $profession->name;
        }

        return $return;
    }

}