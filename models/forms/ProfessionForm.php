<?php

namespace app\models\forms;

use app\models\Profession;


/**
 * Class EmployeeForm
 * @package app\models\forms
 */
class ProfessionForm extends Profession
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['profession_id'], 'integer' ],
            [ ['name', 'code'], 'string' ],
            [ ['name', 'code'], 'required', 'message' => 'Обов\'язкове поле' ],
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
     * @return ProfessionForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}