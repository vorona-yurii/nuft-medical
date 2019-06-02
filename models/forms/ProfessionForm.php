<?php

namespace app\models\forms;

use app\models\Analysis;
use app\models\Doctor;
use app\models\Periodicity;
use app\models\Profession;
use app\models\ProfessionAnalysis;
use app\models\ProfessionDoctor;
use app\models\ProfessionPeriodicity;


/**
 * Class ProfessionForm
 * @package app\models\forms
 */
class ProfessionForm extends Profession
{
    public $analysis;
    public $doctor;
    public $periodicity;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['profession_id'], 'integer' ],
            [ ['name', 'code'], 'string' ],
            [ ['name', 'code', 'analysis', 'doctor', 'periodicity'], 'required', 'message' => 'Обов\'язкове поле' ],
        ];
    }

    /**
     * @return $this|null
     */
    public function edit()
    {
        if (!$this->validate()) {
           return null;
        }

        if( $this->save() ) {
            if( $this->analysis ) {
                ProfessionAnalysis::deleteAll();
                foreach ($this->analysis as $analysis) {
                    if($analysis = Analysis::findOne($analysis)) {
                        $professionAnalysis = new ProfessionAnalysis();
                        $professionAnalysis->profession_id = $this->profession_id;
                        $professionAnalysis->analysis_id   = $analysis->analysis_id;
                        $professionAnalysis->save();
                    }
                }
            }
            if( $this->doctor ) {
                ProfessionDoctor::deleteAll();
                foreach ($this->doctor as $doctor) {
                    if($doctor = Doctor::findOne($doctor)) {
                        $professionDoctor = new ProfessionDoctor();
                        $professionDoctor->profession_id = $this->profession_id;
                        $professionDoctor->doctor_id     = $doctor->doctor_id;
                        $professionDoctor->save();
                    }
                }
            }
            if( $this->periodicity ) {
                if( !$professionPeriodicity = ProfessionPeriodicity::findOne(['profession_id' => $this->profession_id]) ) {
                    $professionPeriodicity = new ProfessionPeriodicity();
                }
                $professionPeriodicity->profession_id   = $this->profession_id;
                $professionPeriodicity->periodicity_id  = $this->periodicity;
                $professionPeriodicity->save();
            }
        }

        return $this;
    }

    /**
     * @return ProfessionForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}