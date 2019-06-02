<?php

namespace app\controllers;

use PhpOffice\PhpWord\PhpWord;
use app\models\Department;
use app\models\Employee;
use app\models\search\EmployeeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class ReportController extends Controller
{
    public $layout = '@app/views/layouts/inner.php';

    private $templateDir = '@app/views/report/templates/';
    private $template = null;

    private $document = null;
    private $documentValues = [];
    private $documentTableRows = [];

    protected function setTemplate($template)
    {
        $this->template = $template;
    }

    protected function setDocumentValues($values)
    {
        $this->documentValues = $values;
    }

    protected function setDocumentTableRows($rows)
    {
        $this->documentTableRows = $rows;
    }

    private function createAndReturnDocument()
    {
        $this->initDocument();
        $this->fillDocument();
        $this->returnDocumentForDownload();
    }

    private function initDocument()
    {
        $PHPWord = new PHPWord();
        $templateFullPath = Yii::getAlias($this->templateDir.$this->template);

        $this->document = $PHPWord->loadTemplate($templateFullPath);
    }

    private function fillDocument()
    {
        foreach ($this->documentValues as $key => $value) {
            $this->document->setValue($key, $value);
        }

        if (!empty($this->documentTableRows)) {
            $rows = $this->documentTableRows;
            $firstColumnName = array_keys($rows[0])[0];
            $this->document->cloneRow($firstColumnName, count($rows));
            foreach ($rows as $rowId => $row) {
                foreach ($row as $key => $value) {
                    $this->document->setValue($key.'#'.($rowId + 1), $value);
                }
            }
        }
    }

    private function returnDocumentForDownload($attachmentName = 'Report.docx')
    {
        $attachment = $this->document->save();
        if (file_exists($attachment)) {
            Yii::$app->response->sendFile($attachment, $attachmentName);
            unlink($attachment);
        } else {
            echo 'An error occurred while creating the file';
        }
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // /**
    //  * @return array
    //  */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'actions'      => [ 'employee' ],
    //                     'allow'        => true,
    //                     'roles'        => [ '@' ],
    //                     'denyCallback' => function ( $rule, $action ) {
    //                         return $action->controller->redirect( [ 'user/login' ] );
    //                     },
    //                 ],
    //             ],

    //         ],
    //     ];
    // }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect( ['employee'] );
    }

    /**
     * @return string
     */
    public function actionEmployee()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render('employee', compact('searchModel', 'dataProvider'));
    }

    public function actionEmployeeMedicalCardDownload($employeeId)
    {
        $this->setTemplate('employee-medical-card.docx');

        $employee = Employee::findOne($employeeId);
        if( $employee ) {
            $this->setDocumentValues([
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
            ]);

            $this->createAndReturnDocument();
        }
    }

    public function actionEmployeeMedicalReferralDownload($employeeId)
    {
        $this->setTemplate('employee-medical-referral.docx');

        $this->setDocumentValues([
            'currentYear'            => date('Y'),
            'employeeSecondName'     => 'Труш',
            'employeeFirstName'      => 'Артем',
            'employeeMiddleName'     => 'Юрійович',
            'employeeBirthYear'      => '1998',
            'employeeProfessionCode' => '00123',
            'employeeProfessionName' => 'програмист',
            'employeeFactors'        => 'кислота, луги',
        ]);

        $this->createAndReturnDocument();
    }

    public function actionMedicalExaminationScheduleDownload()
    {
        $this->setTemplate('medical-examination-schedule.docx');

        $this->setDocumentValues([
            'currentYear'            => date('Y'),
            'employeeSecondName'     => 'Труш',
            'employeeFirstName'      => 'Артем',
            'employeeMiddleName'     => 'Юрійович',
            'employeeBirthYear'      => '1998',
            'employeeProfessionCode' => '00123',
            'employeeProfessionName' => 'програмист',
            'employeeFactors'        => 'кислота, луги',
        ]);

        $this->createAndReturnDocument();
    }

    public function actionMedicalExaminationWorkersListDownload()
    {
        $this->setTemplate('medical-examination-workers-list.docx');

        $this->setDocumentValues([
            'currentYear'            => date('Y'),
            'employeeSecondName'     => 'Труш',
            'employeeFirstName'      => 'Артем',
            'employeeMiddleName'     => 'Юрійович',
            'employeeBirthYear'      => '1998',
            'employeeProfessionCode' => '00123',
            'employeeProfessionName' => 'програмист',
            'employeeFactors'        => 'кислота, луги',
        ]);

        $this->createAndReturnDocument();
    }

    public function actionWorkersCategoriesActDownload()
    {
        $this->setTemplate('workers-categories-act.docx');

        $this->setDocumentValues([
            'currentYear'            => date('Y'),
            'employeeSecondName'     => 'Труш',
            'employeeFirstName'      => 'Артем',
            'employeeMiddleName'     => 'Юрійович',
            'employeeBirthYear'      => '1998',
            'employeeProfessionCode' => '00123',
            'employeeProfessionName' => 'програмист',
            'employeeFactors'        => 'кислота, луги',
        ]);

        $this->createAndReturnDocument();
    }
}
