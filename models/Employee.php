<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $employee_id                          integer
 * @property $department_id                        integer
 * @property $full_name                            string
 * @property $phone                                string
 * @property $email                                string
 * @property $gender                               integer
 * @property $birth_date                           string
 * @property $residence                            string
 * @property $position_id                          integer
 * @property $work_experience                      string
 * @property $additional_info                      text
 * @property $first_medical_examination_date       string
 * @property $last_medical_examination_date        string
 * @property $weight                               integer
 * @property $height                               integer
 * @property $arterial_pressure                    string
 * @property $medical_conclusion                   text
 */

class Employee extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * @return array
     */
    public static function getGenderArray()
    {
        return [
            null => 'Не вказано',
            0    => 'Чоловіча',
            1    => 'Жіноча'
        ];
    }

    /**
     * @return array
     */
    public static function getAllEmployees()
    {
        $return[ null ] = 'Не вказано';

        $employees = self::find()->all();
        foreach ($employees as $employee) {
            $return[$employee->employee_id] = $employee->full_name;
        }

        return $return;
    }

}