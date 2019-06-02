<?php

namespace app\models\forms;

use app\models\Periodicity;


/**
 * Class PeriodicityForm
 * @package app\models\forms
 */
class PeriodicityForm extends Periodicity
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['periodicity_id'], 'integer' ],
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
     * @return PeriodicityForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}