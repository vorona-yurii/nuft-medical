<?php

namespace app\models\forms;

use app\models\Employee;


/**
 * Class EmployeeForm
 * @package app\models\forms
 */
class EmployeeForm extends Employee
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['employee_id', 'gender', 'position_id'], 'integer'],
            [
                [   'phone', 'birth_date', 'residence', 'work_experience', 'additional_info',
                    'weight', 'height', 'first_medical_examination_date', 'last_medical_examination_date',
                    'arterial_pressure', 'medical_conclusion'
                ], 'string'],
            ['email', 'email'],
            [['full_name'], 'required', 'message' => 'Обов\'язкове поле'],
        ];
    }

    /**
     * @return $this|null
     */
    public function edit()
    {
        if (!$this->validate()) {
           return null;
        }

        $this->save();

        return $this;
    }

    /**
     * @return EmployeeForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}