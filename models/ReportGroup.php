<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $report_group_id      integer
 * @property $report_id            integer
 * @property $report_position      string
 * @property $date_medical_check   string
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
}
