<?php

namespace app\modules\quiz\src\helpers;

use yii\helpers\Json;

class AnalyticsHelper
{
    public static function getAnalyticsDataByDepartments($quiz_id)
    {
        return Json::encode([
            [
                'name' => 'Господарський відділ',
                'value' => '80.5'
            ],
            [
                'name' => 'Бібліотека',
                'value' => '75'
            ],
            [
                'name' => 'Хімічна лабораторія',
                'value' => '48',
            ],
            [
                'name' => 'Кухня',
                'value' => '60',
            ],
        ]);
    }

    public static function getAnalyticsDataBySubjects($department_id)
    {
        return Json::encode([
            [
                'name' => 'Тема "Охорона праці"',
                'value' => '50.8'
            ],
            [
                'name' => 'Тема "Виробничий травматизм"',
                'value' => '75.1'
            ],
            [
                'name' => 'Тема "Техніка інструктажу"',
                'value' => '48.9',
            ]
        ]);
    }
}