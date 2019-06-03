<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $report_group_id           integer
 * @property $report_id                 integer
 * @property $report_group_employee     text
 * @property $report_group_department   text
 * @property $date_medical_check        string
 */

class ReportGroup extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%report_group}}';
    }

    public function getExaminationDate()
    {
        return $this->$date_medical_check ? date('d.m', strtotime($this->$date_medical_check)) : '';
    }

    public function getCollectedEmployees()
    {
        $collectedEmployees = [];
        $employeesIds = json_decode($this->report_group_employee);
        $departmentsIds = json_decode($this->report_group_department);

        if ($employeesIds) {
            $employees = Employee::findAll($employeesIds);

            foreach ($employees as $employee) {
                $collectedEmployees[ $employee->employee_id ] = $employee;
            }
        }

        if ($departmentsIds) {
            $departmentsEmployees = Employee::find()
                ->innerJoin('position', 'employee.position_id = position.position_id')
                ->where(['position.department_id' => $departmentsIds])
                ->all();

            foreach ($departmentsEmployees as $employee) {
                $collectedEmployees[ $employee->employee_id ] = $employee;
            }
        }

        return $collectedEmployees;
    }
}
