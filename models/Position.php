<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $position_id       integer
 * @property $name              string
 * @property $profession_id     integer
 * @property $department_id     integer
 * @property $additional_info   text
 */

class Position extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%position}}';
    }

    public function getDepartment()
    {
        return Department::findOne($this->department_id);
    }

    public function getProfession()
    {
        return Profession::findOne($this->profession_id);
    }

    /*
    * @return array
    */
    public static function getAllPositions()
    {
        $return[ null ] = 'Не вказано';

        $positions = self::find()->all();
        foreach ($positions as $position) {
            $return[$position->position_id] = $position->name;
        }

        return $return;
    }
}