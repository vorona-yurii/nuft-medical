<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $department_id          integer
 * @property $name                   string
 * @property $head_employee_id       integer
 * @property $additional_info        text
 */

class Department extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%department}}';
    }

}