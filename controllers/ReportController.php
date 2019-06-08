<?php

namespace app\controllers;

use app\models\forms\ReportForm;
use app\models\service\Notification;
use app\models\ReportGroup;
use app\models\ReportGroupEmployee;
use app\models\search\ReportEmployeeSearch;
use app\models\search\ReportSearch;
use Codeception\PHPUnit\ResultPrinter\Report;
use PhpOffice\PhpWord\PhpWord;
use app\models\Department;
use app\models\Employee;
use app\models\Report as ReportModel;
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

    private $documentSaveOnlyMode = false;

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

    protected function setDocumentSaveOnlyMode($mode = false)
    {
        $this->documentSaveOnlyMode = $mode;
    }

    protected function setAttachmentName($attachmentName, $attachmentExtension = 'docx')
    {
        $this->attachmentName = $attachmentName.'.'.$attachmentExtension;
    }

    private function createAndReturnDocument()
    {
        $this->initDocument();
        $this->fillDocument();
        return $this->returnDocumentForDownload();
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

    private function getTemplateLineBreak()
    {
        return "</w:t><w:br/><w:t>";
    }

    private function reportCreationError()
    {
        echo 'An error occurred while creating the file';
    }

    private function returnDocumentForDownload()
    {
        $attachment = $this->document->save();
        if (file_exists($attachment)) {
            if ($this->documentSaveOnlyMode) {
                return $attachment;
            } else {
                Yii::$app->response->sendFile($attachment, $this->attachmentName);
                unlink($attachment);
                return true;
            }
        } else {
            $this->reportCreationError();
        }

        return false;
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
                            'list', 'list-change', 'list-delete', 'notify',
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
        $searchModel = new ReportEmployeeSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render('employee', compact('searchModel', 'dataProvider'));
    }

    /**
     * @param $report_id
     * @return \yii\web\Response
     */
    public function actionNotify( $report_id )
    {
        $mailer = Notification::sendMail( $report_id );

        if( $mailer['success'] ) {
            Yii::$app->session->setFlash( 'success', 'Повідомлення про медогляд успішно відправлено ' . $mailer['count'] . ' працівникам(у)' );
        }
        if ( $mailer['error'] ) {
            Yii::$app->session->setFlash( 'error', 'Помилка відправки повідомлень' );
        }

        return $this->redirect( [ 'report/list' ] );
    }

    public function actionEmployeeMedicalCardDownload($employeeId)
    {
        $employee = Employee::findOne($employeeId);
        if (!$employee) {
            return $this->reportCreationError();
        }

        list($position, $department, $profession) = $employee->getDependentData();
        $doctorsNames = $position->getDoctorsNames();

        $this->setTemplate('employee-medical-card.docx');
        $this->setAttachmentName('Картка_'.$employee->getNameInitials());

        $this->setDocumentValues([
            'employeeFullName'   => $employee->full_name,
            'employeeGender'     => $employee->getGender(),
            'employeeBirthYear'  => $employee->getFormattedDate('birth_date', 'Y'),
            'employeeResidence'  => $employee->residence,
            'employeeCompany'    => 'Національний Університет Харчових Технологій',
            'employeeDepartment' => $department->name,
            'employeeProfession' => $profession->getCombinedName(),
            'factors'            => implode(', ', $position->getFactorsCombinedNames()),
            'periodicities'      => implode(', ', $position->getPeriodicitiesCombinedNames()),
            'doctors'            => implode(', ', $doctorsNames),
            'analyzes'           => implode(', ', $position->getAnalyzesNames()),
            'employeeWeight'     => $employee->getHumanWeight(),
            'employeeHeight'     => $employee->getHumanHeight(),
            'employeeAT'         => $employee->arterial_pressure,
        ]);

        $doctors = array_merge($doctorsNames, ['Інші фахівці']);
        $doctorsRows = [];
        foreach ($doctors as $doctorKey => $doctorName) {
            $doctorsRows[] = [
                'doctorNumber' => $doctorKey + 1,
                'doctorName' => $doctorName
            ];
        }

        $this->setDocumentBlocks([
            'doctorBlock' => $doctorsRows,
        ]);

        return $this->createAndReturnDocument();
    }

    public function actionEmployeeMedicalReferralDownload($employeeId)
    {
        $employee = Employee::findOne($employeeId);
        if (!$employee) {
            return $this->reportCreationError();
        }

        list($position, $department, $profession) = $employee->getDependentData();

        $this->setTemplate('employee-medical-referral.docx');
        $this->setAttachmentName('Направлення_'.$employee->getNameInitials());

        $this->setDocumentValues([
            'currentYear'            => date('Y'),
            'employeeSecondName'     => $employee->getNamePart('second'),
            'employeeFirstName'      => $employee->getNamePart('first'),
            'employeeMiddleName'     => $employee->getNamePart('middle'),
            'employeeBirthYear'      => $employee->getFormattedDate('birth_date', 'Y'),
            'employeeProfessionCode' => $profession->code,
            'employeeProfessionName' => $profession->name,
            'employeeFactors'        => implode(', ', $position->getFactorsCombinedNames()),
            'employeeHint'           => implode($this->getTemplateLineBreak(), $position->getDoctorsHints()),
        ]);

        return $this->createAndReturnDocument();
    }

    public function actionMedicalExaminationScheduleDownload($reportId)
    {
        $report = ReportModel::findOne($reportId);
        if (!$report) {
            return $this->reportCreationError();
        }

        $groups = $report->getEmployeesGroups();
        if (!$groups) {
            return $this->reportCreationError();
        }

        $employeesRows = [];
        $employeesCounter = 0;
        foreach ($groups as $group) {
            foreach ($group['employees'] as $employee) {
                $employeesCounter++;
                list($position, $department, $profession) = $employee->getDependentData();

                $employeesRows[] = [
                    'examinationDate'   => $group['examinationDate'],
                    'employeeNumber'    => $employeesCounter,
                    'employeeListIndex' => $employee->getListIndex(),
                    'employeeFullName'  => $employee->full_name,
                    'depatmentName'     => $department->name,
                ];
            }
        }

        $this->setTemplate('medical-examination-schedule.docx');
        $this->setAttachmentName('ГрафікМедогляду_'.$report->name);

        $this->setDocumentTableRows($employeesRows);

        return $this->createAndReturnDocument();
    }

    public function actionMedicalExaminationWorkersListDownload($reportId)
    {
        $report = ReportModel::findOne($reportId);
        if (!$report) {
            return $this->reportCreationError();
        }

        $employees = $report->getUniqueEmployees();
        if (!$employees) {
            return $this->reportCreationError();
        }

        $employeesRows = [];
        foreach ($employees as $employee) {
            list($position, $department, $profession) = $employee->getDependentData();
            $index = $employee->getListIndex();
            $employeesRows[ $index - 1 ] = [
                'employeeNumber'                     => $index,
                'employeeFullName'                   => $employee->full_name,
                'employeeGender'                     => $employee->getGender(),
                'employeeBirthDate'                  => $employee->getFormattedDate('birth_date'),
                'employeeDepartment'                 => $department->name,
                'employeeProfessionCode'             => $profession->code,
                'employeeProfessionName'             => $profession->name,
                'factors'                            => implode(', ', $position->getFactorsCombinedNames()),
                'doctors'                            => implode(', ', $position->getDoctorsNames()),
                'analyzes'                           => implode(', ', $position->getAnalyzesNames()),
                'employeeWorkExperience'             => $employee->work_experience,
                'employeeLastMedicalExaminationDate' => $employee->getFormattedDate('last_medical_examination_date'),
            ];
        }

        $this->setTemplate('medical-examination-workers-list.docx');
        $this->setAttachmentName('СписокПрацівників_'.$report->name);

        $this->setDocumentValues([
            'currentYear' => date('Y'),
        ]);

        $this->setDocumentTableRows($employeesRows);

        return $this->createAndReturnDocument();
    }

    public function actionWorkersCategoriesActDownload($reportId)
    {
        $report = ReportModel::findOne($reportId);
        if (!$report) {
            return $this->reportCreationError();
        }

        $employees = $report->getUniqueEmployees();
        if (!$employees) {
            return $this->reportCreationError();
        }

        $departments = [];
        $employeesTotalCount = 0;
        $womanEmployeesTotalCount = 0;
        foreach ($employees as $employee) {
            list($position, $department, $profession) = $employee->getDependentData();
            $departmentId = $department->department_id;
            $professionId = $profession->profession_id;

            $professions = [$professionId => [
                'name'                => $profession->name,
                'code'                => $profession->code,
                'employeesCount'      => 1,
                'womanEmployeesCount' => intval($employee->gender),
            ]];
            $factors = $position->getFactorsCombinedNames();

            if (isset($departments[ $departmentId ])) {
                $existingProfessions = $departments[ $departmentId ]['professions'];
                $existingFactors = $departments[ $departmentId ]['factors'];

                if (isset($existingProfessions[ $professionId ])) {
                    $existingProfessions[ $professionId ]['employeesCount'] +=
                        $professions[ $professionId ]['employeesCount'];
                    $existingProfessions[ $professionId ]['womanEmployeesCount'] +=
                        $professions[ $professionId ]['womanEmployeesCount'];
                }
                $professions = $existingProfessions + $professions;
                $factors = array_unique(array_merge($factors, $existingFactors));
            }

            $departments[ $departmentId ] = [
                'name'        => $department->name,
                'professions' => $professions,
                'factors'     => $factors,
            ];

            $employeesTotalCount++;
            $womanEmployeesTotalCount += intval($employee->gender);
        }

        $break = ','.$this->getTemplateLineBreak();
        $departmentsRows = [];
        foreach (array_values($departments) as $key => $department) {
            $professionsNames = array_column($department['professions'], 'name');
            $professionsCodes = array_column($department['professions'], 'code');
            $professionsEmployeesCounts = array_column($department['professions'], 'employeesCount');
            $professionsWomanEmployeesCounts = array_column($department['professions'], 'womanEmployeesCount');

            $departmentsRows[] = [
                'departmentNumber'                     => $key + 1,
                'departmentName'                       => $department['name'],
                'departmentProfessionsNames'           => implode($break, $professionsNames),
                'departmentProfessionsCodes'           => implode($break, $professionsCodes),
                'departmentProfessionsEmployeesCounts' => implode($break, $professionsEmployeesCounts),
                'departmentFactors'                    => implode($break, $department['factors']),
                'departmentEmployeesTotalCount'        => array_sum($professionsEmployeesCounts),
                'departmentWomanEmployeesTotalCount'   => array_sum($professionsWomanEmployeesCounts),
            ];
        }

        $this->setTemplate('workers-categories-act.docx');
        $this->setAttachmentName('АктКатегорійПрацівників_'.$report->name);

        $this->setDocumentValues([
            'currentYear'               => date('Y'),
            'employeesTotalCount'       => $employeesTotalCount,
            'womanEmployeesTotalCount'  => $womanEmployeesTotalCount,
        ]);

        $this->setDocumentTableRows($departmentsRows);

        return $this->createAndReturnDocument();
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render( 'list', compact('searchModel', 'dataProvider' ) );
    }

    /**
     * @param $action
     * @param int $id
     *
     * @return string|\yii\web\Response
     */
    public function actionListChange($action, $id = 0 )
    {
        if( $model = ReportForm::findOne(['report_id' => $id]) ) {
            $report_groups = ReportGroup::findAll(['report_id' => $id]);
            foreach ($report_groups as $report_group) {
                $model->report_group[] = [
                    'date_medical_check' => $report_group->date_medical_check,
                    'department'         => json_decode($report_group->report_group_department),
                    'employee'           => json_decode($report_group->report_group_employee),
                ];
            }
        } else {
            $model = new ReportForm();
        }

        if( method_exists($model, $action) ) {
            if ( Yii::$app->request->isPost && $model->load( Yii::$app->request->post() ) ) {
                if ( $model->$action() ) {
                    Yii::$app->session->setFlash( 'success', 'Список успішно додано' );
                    return $this->redirect( [ 'report/list' ] );
                } else {
                    Yii::$app->session->setFlash( 'error', 'Помилка збереження' );
                }
            }

            return $this->render( 'edit', compact( 'model', 'id' ) );
        }

        return $this->redirect( ['list'] );
    }


    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionListDelete()
    {
        $id     = Yii::$app->request->post('id');
        $report = \app\models\Report::findOne([$id]);

        if ( $report && Yii::$app->request->isAjax ) {
            ReportGroup::DeleteAll(['report_id' => $id]);
            $report->delete();

            return true;
        }

        return false;
    }
}
