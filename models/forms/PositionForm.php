<?php

namespace app\models\forms;

use app\models\Factor;
use app\models\Position;
use app\models\PositionFactor;


/**
 * Class PositionForm
 * @package app\models\forms
 */
class PositionForm extends Position
{
    public $factors;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['position_id', 'profession_id', 'department_id'], 'integer' ],
            [ ['name', 'additional_info'], 'string' ],
            [ ['name', 'profession_id', 'department_id', 'factors'], 'required', 'message' => 'Обов\'язкове поле' ],
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

        if( $this->save() && $this->factors ) {
            PositionFactor::deleteAll();
            foreach ($this->factors as $factor) {
                if($factor = Factor::findOne($factor)) {
                    $positionFactor = new PositionFactor();
                    $positionFactor->position_id = $this->position_id;
                    $positionFactor->factor_id   = $factor->factor_id;
                    $positionFactor->save();
                }
            }
        }

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