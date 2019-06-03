<?php

namespace app\models\forms;

use app\models\Employee;
use app\models\Factor;
use app\models\Position;
use app\models\PositionFactor;
use app\models\Report;
use app\models\ReportGroup;
use app\models\ReportGroupEmployee;


/**
 * Class ReportForm
 * @package app\models\forms
 */
class ReportForm extends Report
{
    public $report_group;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['report_id'], 'integer' ],
            [ ['name'], 'string' ],
            [ ['report_group'], 'safe' ],
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

        if( $this->save() && $this->report_group ) {
            ReportGroup::deleteAll(['report_id' => $this->report_id]);
            foreach ($this->report_group as $report_group) {
                $reportGroup = new ReportGroup();
                $reportGroup->report_id = $this->report_id;
                $reportGroup->report_group_employee = json_encode($report_group['employee'] ?? '[]');
                $reportGroup->report_group_department = json_encode($report_group['department'] ?? '[]');
                $reportGroup->date_medical_check = $report_group['date_medical_check'] ?? '';
                $reportGroup->save();
            }
        }

        return $this;
    }

    /**
     * @return ReportForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}