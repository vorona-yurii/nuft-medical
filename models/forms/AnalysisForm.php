<?php

namespace app\models\forms;

use app\models\Analysis;


/**
 * Class AnalysisForm
 * @package app\models\forms
 */
class AnalysisForm extends Analysis
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['analysis_id'], 'integer' ],
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
     * @return AnalysisForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}