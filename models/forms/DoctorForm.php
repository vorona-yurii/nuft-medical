<?php

namespace app\models\forms;

use app\models\Doctor;


/**
 * Class DoctorForm
 * @package app\models\forms
 */
class DoctorForm extends Doctor
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['doctor_id'], 'integer' ],
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
     * @return DoctorForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}