<?php

namespace app\controllers\report;

class MedicalExaminationScheduleController extends BaseController
{
    protected $template = 'medical-examination-schedule.docx';

    public function actionDownload()
    {
        $this->documentValues = [
            'currentYear'            => date('Y'),
            'employeeSecondName'     => 'Труш',
            'employeeFirstName'      => 'Артем',
            'employeeMiddleName'     => 'Юрійович',
            'employeeBirthYear'      => '1998',
            'employeeProfessionCode' => '00123',
            'employeeProfessionName' => 'програмист',
            'employeeFactors'        => 'кислота, луги',
        ];

        $this->createAndReturnDocument();
    }
}
