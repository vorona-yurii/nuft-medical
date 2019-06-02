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

    /**
     * @return array
     */
    public static function getAllDepartments()
    {
        $return[ null ] = 'Не вказано';

        $departments = self::find()->all();
        foreach ($departments as $department) {
            $return[$department->department_id] = $department->name;
        }

        return $return;
    }

}