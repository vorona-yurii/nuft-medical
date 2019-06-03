<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property $report_id       integer
 * @property $name            string
 * @property $created_at      string
 * @property $updated_at      string
 */

class Report extends ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%report}}';
    }

    public function getEmployeesGroups()
    {
        $reportGroups = ReportGroup::findAll(['report_id' => $this->report_id]);

        $groups = [];
        $employeesCounter = 0;
        $employeesIndexes = [];

        foreach ($reportGroups as $reportGroup) {
            $employees = $reportGroup->getCollectedEmployees();
            if (!$employees) {
                continue;
            }

            foreach ($employees as &$employee) {
                if (!isset($employeesIndexes[ $employee->employee_id ])) {
                    $employeesCounter++;
                    $employeesIndexes[ $employee->employee_id ] = $employeesCounter;
                }

                $employee->setListIndex($employeesIndexes[ $employee->employee_id ]);
            }

            $groups[] = [
                'examinationDate' => $reportGroup->getExaminationDate(),
                'employees' => array_values($employees),
            ];
        }


        return $groups;
    }

    public function getUniqueEmployees()
    {
        $employeesGroups = $this->getEmployeesGroups();
        $employees = [];
        foreach ($employeesGroups as $employeesGroup) {
            foreach ($employeesGroup['employees'] as $employee) {
                $employees[ $employee->employee_id ] = $employee;
            }
        }

        return array_values($employees);
    }
}
