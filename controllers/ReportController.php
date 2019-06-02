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
    private $documentBlocks = [];

    private $attachmentName = 'Report.docx';

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

    protected function setDocumentBlocks($blocks)
    {
        $this->documentBlocks = $blocks;
    }

    protected function setAttachmentName($attachmentName, $attachmentExtension = 'docx')
    {
        $this->attachmentName = $attachmentName.'.'.$attachmentExtension;
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
        // values
        foreach ($this->documentValues as $key => $value) {
            $this->document->setValue($key, $value);
        }

        // tables
        if (!empty($this->documentTableRows)) {
            $rows = $this->documentTableRows;
            $firstColumnName = array_keys($rows[0])[0];
            $this->document->cloneRow($firstColumnName, count($rows));
            foreach ($rows as $rowId => $rowValues) {
                foreach ($rowValues as $key => $value) {
                    $this->document->setValue($key.'#'.($rowId + 1), $value);
                }
            }
        }

        // blocks
        foreach ($this->documentBlocks as $blockName => $blockRows) {
            if (count($blockRows)) {
                $this->document->cloneBlock($blockName, count($blockRows), true, true);
                foreach ($blockRows as $rowId => $rowValues) {
                    foreach ($rowValues as $key => $value) {
                        $this->document->setValue($key.'#'.($rowId + 1), $value);
                    }
                }
            } else {
                $this->document->deleteBlock($blockName);
            }
        }
    }

    private function reportCreationError()
    {
        echo 'An error occurred while creating the file';
    }

    private function returnDocumentForDownload()
    {
        error_log($this->attachmentName);

        $attachment = $this->document->save();
        if (file_exists($attachment)) {
            Yii::$app->response->sendFile($attachment, $this->attachmentName);
            unlink($attachment);
        } else {
            $this->reportCreationError();
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

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions'      => [
                            'employee',
                            'employee-medical-card-download',
                            'employee-medical-referral-download',
                            'medical-examination-schedule-download',
                            'medical-examination-workers-list-download',
                            'workers-categories-act-download',
                        ],
                        'allow'        => true,
                        'roles'        => [ '@' ],
                        'denyCallback' => function ( $rule, $action ) {
                            return $action->controller->redirect( [ 'user/login' ] );
                        },
                    ],
                ],

            ],
        ];
    }

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
        $employee = Employee::findOne($employeeId);
        if (!$employee) {
            return $this->reportCreationError();
        }

        list($position, $department, $profession) = $employee->getDependentData();

        $this->setTemplate('employee-medical-card.docx');
        $this->setAttachmentName('КарткаПрацівника_'.$employee->getNameInitials());

        $this->setDocumentValues([
            'employeeFullName'   => $employee->full_name,
            'employeeGender'     => $employee->getGender(),
            'employeeBirthYear'  => $employee->getBirthDate('Y'),
            'employeeResidence'  => $employee->residence,
            'employeeCompany'    => 'Національний Університет Харчових Технологій',
            'employeeDepartment' => $department->name,
            'employeeProfession' => $profession->getCombinedName(),
            'factors'            => '',
            'doctors'            => '',
            'analyzes'           => '',
            'employeeWeight'     => $employee->getHumanWeight(),
            'employeeHeight'     => $employee->getHumanHeight(),
            'employeeAT'         => $employee->arterial_pressure,
        ]);

        $this->setDocumentBlocks([
            'doctorBlock' => [
                ['doctorNumber' => 1, 'doctorName' => 'Хирург'],
                ['doctorNumber' => 2, 'doctorName' => 'Невропатолог'],
            ],
        ]);

        $this->createAndReturnDocument();
    }

    public function actionEmployeeMedicalReferralDownload($employeeId)
    {
        $employee = Employee::findOne($employeeId);
        if (!$employee) {
            return $this->reportCreationError();
        }

        $this->setTemplate('employee-medical-referral.docx');

        $this->setDocumentValues([
            'currentYear'            => date('Y'),
            'employeeSecondName'     => $employee->getNamePart('second'),
            'employeeFirstName'      => $employee->getNamePart('first'),
            'employeeMiddleName'     => $employee->getNamePart('middle'),
            'employeeBirthYear'      => $employee->getBirthDate('Y'),
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
