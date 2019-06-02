<?php

namespace app\controllers\report;

use app\models\Department;
use app\models\Employee;

class EmployeeMedicalCardController extends BaseController
{
    protected $template = 'employee-medical-card.docx';

    public function actionDownload($id)
    {
        $employee = Employee::findOne($id);
        if( $employee ) {
            $this->documentValues = [
                'employeeFullName'       => $employee->full_name,
                'employeeGender'         => $employee->gender,
                'employeeBirthYear'      => $employee->birth_date,
                'employeeResidence'      => $employee->residence,
                'employeeCompany'        => 'Національний Університет Харчових Технологій',
                'employeeDepartment'     => Department::findOne($employee->department_id) ? Department::findOne($employee->department_id)->name : '',
                'employeeProfession'     => $employee->position_id,
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