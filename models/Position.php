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
}