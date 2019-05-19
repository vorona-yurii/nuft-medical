<?php

namespace app\models\forms;

use app\models\Department;


/**
 * Class DepartmentForm
 * @package app\models\forms
 */
class DepartmentForm extends Department
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['department_id', 'head_employee_id'], 'integer' ],
            [ [ 'additional_info'], 'string' ],
            [ ['name'], 'required', 'message' => 'Обов\'язкове поле' ],
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
     * @return DepartmentForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}