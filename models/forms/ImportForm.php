<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Position;
use app\models\Employee;

class ImportForm extends Model
{
    public $csvFile;
    private $parseErrors = [];
    private $parseWarnings = [];
    private $parseResults = [];

    public function rules()
    {
        return [
            [
                ['csvFile'],
                'file',
                'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false,
                'extensions' => 'csv',
            ]
        ];
    }

    public function import()
    {
        $this->csvFile = UploadedFile::getInstance($this, 'csvFile');

        if ($this->validate()) {
            try {
                $employees = $this->parseFile($this->csvFile->tempName);
                if (!$this->parseErrors) {
                    $this->saveEmployees($employees);
                }

                return [
                    'errors' => $this->parseErrors,
                    'warnings' => $this->parseWarnings,
                    'results' => $this->parseResults,
                ];
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }

    private function saveEmployees($employees)
    {
        $savedCount = 0;
        $skippedCount = 0;
        foreach ($employees as $employeeData) {
            if (Employee::findOne(['full_name' => $employeeData['full_name']])) {
                $this->parseWarnings[] = 'Працівник "'.$employeeData['full_name'].'" вже існує';
                $skippedCount++;
                continue;
            }

            $employee = new Employee();
            foreach ($employeeData as $key => $value) {
                $employee->$key = $value;
            }
            $employee->save();
            $savedCount++;
        }

        $this->parseResults[] = $savedCount.' працівників успішно імпортовано, '.$skippedCount.' пропущено';
    }

    private function parseFile($filename)
    {
        $content = file_get_contents($filename);
        $delimiter = $this->detectDelimiter($content);
        $rows = str_getcsv($content, "\n");

        $data = [];
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }

            $cols = str_getcsv($row, $delimiter);
            $data[] = [
                'full_name'                       => $this->formatFullNameField($cols[0] ?? ''),
                'position_id'                     => $this->formatPositionField($cols[1] ?? ''),
                'phone'                           => $this->formatPhoneField($cols[2] ?? ''),
                'email'                           => $this->formatTextField($cols[3] ?? ''),
                'gender'                          => $this->formatGenderField($cols[4] ?? ''),
                'birth_date'                      => $this->formatDateField($cols[5] ?? ''),
                'residence'                       => $this->formatTextField($cols[6] ?? ''),
                'work_experience'                 => $this->formatTextField($cols[7] ?? ''),
                'first_medical_examination_date'  => $this->formatDateField($cols[8] ?? ''),
                'last_medical_examination_date'   => $this->formatDateField($cols[9] ?? ''),
                'weight'                          => $this->formatNumberField($cols[10] ?? ''),
                'height'                          => $this->formatNumberField($cols[11] ?? ''),
                'arterial_pressure'               => $this->formatTextField($cols[12] ?? ''),
            ];
        }

        return $data;
    }

    private function formatFullNameField($fullName)
    {
        $fullName = trim($fullName);

        $nameParts = array_filter(explode(' ', $fullName));
        if (count($nameParts) !== 3) {
            $this->parseErrors[] = 'Некоректний формат ПІБ - "'.$fullName.'"';
            return null;
        }

        return implode(' ', $nameParts);
    }

    private function formatGenderField($gender)
    {
        switch (trim($gender)) {
            case 'чол':
                return 0;
                break;
            case 'жін':
                return 1;
                break;
            default:
                break;
        }

        return null;
    }

    private function formatPositionField($positionName)
    {
        $positionName = trim($positionName);

        $position =  Position::findOne(['name' => $positionName]);
        if (!$position) {
            $this->parseErrors[] = 'Посаду "'.$positionName.'" не знайдено';
            return null;
        }

        return $position->position_id;
    }

    private function formatDateField($date)
    {
        $date = strval($date ? date('d.m.Y', strtotime($date)) : '');
        return $date ?: null;
    }

    private function formatTextField($text)
    {
        return trim($text) ?: null;
    }

    private function formatNumberField($number)
    {
        return intval($number) ?: null;
    }

    private function formatPhoneField($phone)
    {
        $phone = trim($phone);
        if (!$phone) {
            return null;
        }

        if (!preg_match('/^\d{10}$/', $phone)) {
            $this->parseWarnings[] = 'Некоректний формат телефону - "'.$phone.'"';
            return null;
        }

        return (
            "+38({$phone[0]}{$phone[1]}{$phone[2]}) ".
            "{$phone[3]}{$phone[4]}{$phone[5]}-{$phone[6]}{$phone[7]}-{$phone[8]}{$phone[9]}"
        );
    }

    private function detectDelimiter($text)
    {
        $delimiters = [
            ';' => 0,
            ',' => 0,
            "\t" => 0,
            "|" => 0
        ];

        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($text, $delimiter));
        }

        return array_search(max($delimiters), $delimiters);
    }
}
