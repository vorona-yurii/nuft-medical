<?php

namespace app\models\forms;

use app\models\Factor;


/**
 * Class DoctorForm
 * @package app\models\forms
 */
class FactorForm extends Factor
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['factor_id'], 'integer' ],
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
     * @return FactorForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}