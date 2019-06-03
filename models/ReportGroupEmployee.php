<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $report_groups_employee_id   integer
 * @property $report_group_id             integer
 * @property $employee_id                 integer
 * @property $employee_index              integer
 */

class ReportGroupEmployee extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%report_group_employee}}';
    }
}
