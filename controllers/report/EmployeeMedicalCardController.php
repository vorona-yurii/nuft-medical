<?php

namespace app\controllers\report;

class EmployeeMedicalCardController extends BaseController
{
    protected $template = 'employee-medical-card.docx';

    public function actionDownload()
    {
        $this->documentValues = [
            'employeeFullName'       => 'Труш',
            'employeeGender'         => '',
            'employeeBirthYear'      => '',
            'employeeResidence'      => '',
            'employeeCompany'        => 'Національний Університет Харчових Технологій',
            'employeeDepartment'     => '',
            'employeeProfession'     => '',
            'employeeFactors'        => '',
            // 'employeeFirstName'      => 'Артем',
            // 'employeeMiddleName'     => 'Юрійович',
            // 'employeeBirthYear'      => '1998',
            // 'employeeProfessionCode' => '00123',
            // 'employeeProfessionName' => 'програмист',
            // 'employeeFactors'        => 'кислота, луги',
        ];

        $this->createAndReturnDocument();
    }
}

 // * @property $employee_id                          integer
 // * @property $department_id                        integer
 // * @property $full_name                            string
 // * @property $phone                                string
 // * @property $email                                string
 // * @property $gender                               integer
 // * @property $birth_date                           string
 // * @property $residence                            string
 // * @property $position_id                          integer
 // * @property $work_experience                      string
 // * @property $additional_info                      text
 // * @property $first_medical_examination_date       string
 // * @property $last_medical_examination_date        string
 // * @property $weight                               integer
 // * @property $height                               integer
 // * @property $arterial_pressure                    string
 // * @property $medical_conclusion                   text