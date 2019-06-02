<?php

namespace app\models\forms;

use app\models\Position;


/**
 * Class EmployeeForm
 * @package app\models\forms
 */
class PositionForm extends Position
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['position_id', 'profession_id', 'department_id'], 'integer' ],
            [ ['name', 'additional_info'], 'string' ],
            [ ['name', 'profession_id', 'department_id'], 'required', 'message' => 'Обов\'язкове поле' ],
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
     * @return PositionForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}