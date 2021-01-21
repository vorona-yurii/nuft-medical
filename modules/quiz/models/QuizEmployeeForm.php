<?php

namespace app\modules\quiz\models;

use app\models\Employee;
use yii\base\Model;
use Yii;

/**
 * Class QuizEmployeeForm
 * @package app\modules\quiz\models
 */
class QuizEmployeeForm extends Model
{
    public $quiz_id;
    public $employees;
    public $positions;

    public function __construct($quiz_id, $config = [])
    {
        $this->quiz_id = $quiz_id;
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['quiz_id'], 'integer'],
            [['employees', 'positions'], 'safe'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'quiz_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employees' => 'Працівники',
            'positions' => 'Підрозділи'
        ];
    }

    public function save()
    {
        if ($this->employees) {
            foreach ($this->employees as $employee_id) {
                QuizEmployee::addEmployee($employee_id, $this->quiz_id);
            }
        }
        if ($this->positions) {
            foreach ($this->positions as $position_id) {
                $employees = Employee::findAll(['position_id' => $position_id]);
                if ($employees) {
                    foreach ($employees as $employee) {
                        QuizEmployee::addEmployee($employee->employee_id, $this->quiz_id);
                    }
                }
            }
        }
        return true;
    }
}