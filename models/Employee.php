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

    public function getGender()
    {
        return self::getGenderArray()[ $this->gender ?? null ];
    }

    public function getNamePart($type = 'first')
    {
        $partsMap = [
            'second' => 0,
            'first'  => 1,
            'middle' => 2,
        ];

        $nameParts = array_filter(explode(' ', $this->full_name ?? ''));

        return $nameParts[ $partsMap[ $type ] ];
    }

    public function getNameInitials()
    {
        return (
            $this->getNamePart('second').
            mb_substr($this->getNamePart('first'), 0, 1).
            mb_substr($this->getNamePart('middle'), 0, 1)
        );
    }

    public function getFormattedDate($field, $format = 'Y-m-d')
    {
        return $this->$field ? date($format, strtotime($this->$field)) : '';
    }

    public function getHumanWeight()
    {
        return $this->weight.'кг';
    }

    public function getHumanHeight()
    {
        return $this->height.'см';
    }

    public function getPosition()
    {
        return Position::findOne($this->position_id);
    }

    public function getDependentData()
    {
        $position = $department = $profession = null;

        $position = $this->getPosition();
        if ($position) {
            $department = $position->getDepartment();
            $profession = $position->getProfession();
        }

        return [$position, $department, $profession];
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