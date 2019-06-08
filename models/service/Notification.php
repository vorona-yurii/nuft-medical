<?php

namespace app\models\service;

use app\models\Employee;
use app\models\ReportGroup;
use app\models\Setting;
use yii\base\Model;


class Notification extends Model
{
    /**
     * @param $report_id
     * @return array
     */
    public static function sendMail( $report_id )
    {
        $count = 0;
        $groups = self::getGroups( $report_id );
        foreach ( $groups as $group ) {
            $send = self::sendMailToGroupEmployee( $group );
            if( $send['error'] ) {
                return [
                    'success' => false,
                    'error'   => true
                ];
            }
            $count += $send['count'];
        }

        return [
            'success' => true,
            'error'   => false,
            'count'   => $count
        ];
    }


    /**
     * @param $report_id
     * @return array
     */
    public static function getGroups( $report_id )
    {
        $reportGroups = ReportGroup::findAll(['report_id' => $report_id]);

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

    /**
     * @param $employee Employee
     * @param $date
     * @return string
     */
    public static function generateMail( $employee, $date )
    {
        list($position, $department, $profession) = $employee->getDependentData();
        $employeeHint =  implode(' ', $position->getDoctorsHints());

        $template = Setting::getSetting('template_email');
        $placeholder = [
            '{{name}}'  => $employee->full_name,
            '{{date}}'  => $date,
            '{{point}}' => $employeeHint,
        ];
        $message = strtr( $template, $placeholder );

        return $message;
    }


    /**
     * @param $group
     * @return array|bool
     */
    public static function sendMailToGroupEmployee( $group )
    {
        if( $group ) {
            $messages = [];

            foreach ($group['employees'] as $employee) {
                $mail = self::generateMail( $employee, $group['examinationDate'] );
                $message = \Yii::$app
                                ->mailer
                                ->compose()
                                ->setFrom( 'notify@nuft-medical.yuv.com.ua' )
                                ->setTo( $employee->email )
                                ->setSubject( 'Повідомлення щодо проходження медогляду' )
                                ->setTextBody( $mail );

                if( Setting::getSetting('enable_email_file') ) {
                    $tmp = \Yii::$app->runAction('report/employee-medical-referral-download', ['employeeId' => $employee->employee_id, 'get_path' => true]);
                    $message->attachContent(file_get_contents($tmp),  ['fileName' => 'Направлення.docx']);
                }

                $messages[] = $message;
            }

            if( count($messages) > 1 ) {
                \Yii::$app->mailer->sendMultiple($messages);
            }else {
                $messages[0]->send();
            }

            return [
                'error' => false,
                'count' => count($messages)
            ];
        }

        return [
            'error' => true
        ];
    }

}