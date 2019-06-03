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
            ReportGroup::deleteAll();
            foreach ($this->report_group as $report_group) {
                $reportGroup = new ReportGroup();
                $reportGroup->report_id = $this->report_id;
                $reportGroup->report_position = json_encode($report_group['position']);
                $reportGroup->date_medical_check = $report_group['date_medical_check'];

                if( $reportGroup_id = $reportGroup->save() && $report_group['employee'] ) {
                    foreach ($report_group['employee'] as $report_group_employee) {
                        if($report_group_employee =  Employee::findOne($report_group_employee) ) {
                            $reportGroupEmployee = new ReportGroupEmployee();
                            $reportGroupEmployee->report_id = $this->report_id;
                            $reportGroupEmployee->report_group_id = $reportGroup->report_group_id;
                            $reportGroupEmployee->employee_id = $report_group_employee->employee_id;
                            $reportGroupEmployee->save();
                        }
                    }
                }

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