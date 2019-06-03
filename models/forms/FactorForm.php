<?php

namespace app\models\forms;

use app\models\Analysis;
use app\models\Doctor;
use app\models\Factor;
use app\models\FactorAnalysis;
use app\models\FactorDoctor;
use app\models\FactorPeriodicity;


/**
 * Class FactorForm
 * @package app\models\forms
 */
class FactorForm extends Factor
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
            [ ['factor_id'], 'integer' ],
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
                FactorAnalysis::deleteAll(['factor_id' => $this->factor_id]);
                foreach ($this->analysis as $analysis) {
                    if($analysis = Analysis::findOne($analysis)) {
                        $factorAnalysis = new FactorAnalysis();
                        $factorAnalysis->factor_id    = $this->factor_id;
                        $factorAnalysis->analysis_id  = $analysis->analysis_id;
                        $factorAnalysis->save();
                    }
                }
            }
            if( $this->doctor ) {
                FactorDoctor::deleteAll(['factor_id' => $this->factor_id]);
                foreach ($this->doctor as $doctor) {
                    if($doctor = Doctor::findOne($doctor)) {
                        $factorDoctor = new FactorDoctor();
                        $factorDoctor->factor_id  = $this->factor_id;
                        $factorDoctor->doctor_id  = $doctor->doctor_id;
                        $factorDoctor->save();
                    }
                }
            }
            if( $this->periodicity ) {
                if( !$factorPeriodicity = FactorPeriodicity::findOne(['factor_id' => $this->factor_id]) ) {
                    $factorPeriodicity = new FactorPeriodicity();
                }
                $factorPeriodicity->factor_id       = $this->factor_id;
                $factorPeriodicity->periodicity_id  = $this->periodicity;
                $factorPeriodicity->save();
            }
        }

        return $this;
    }

    /**
     * @return FactorForm|null
     */
    public function add()
    {
        return $this->edit();
    }
}