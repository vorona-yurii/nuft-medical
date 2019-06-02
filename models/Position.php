<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $position_id       integer
 * @property $name              string
 * @property $profession_id     integer
 * @property $department_id     integer
 * @property $additional_info   text
 */

class Position extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%position}}';
    }

    /*
    * @return array
    */
    public static function getAllPositions()
    {
        $return[ null ] = 'Не вказано';

        $positions = self::find()->all();
        foreach ($positions as $position) {
            $return[$position->position_id] = $position->name;
        }

        return $return;
    }

    public function getDepartment()
    {
        return Department::findOne($this->department_id);
    }

    public function getProfession()
    {
        return Profession::findOne($this->profession_id);
    }

    public function getFactors()
    {
        return Factor::find()
            ->innerJoin('position_factor', 'factor.factor_id = position_factor.factor_id')
            ->where(['position_factor.position_id' => $this->position_id])
            ->all();
    }

    public function getIndexedFactors()
    {
        $indexedFactors = [];
        foreach ($this->getFactors() as $factor) {
            $indexedFactors[ $factor->factor_id ] = $factor;
        }

        return $indexedFactors;
    }

    private function objects_column($objects, $column)
    {
        if (empty($objects)) {
            return [];
        }

        $columnsArray = [];
        foreach ($objects as $object) {
            $columnsArray[] = $object->$column;
        }

        return $columnsArray;
    }

    public function getFactorsCombinedNames()
    {
        $factorsNames = [];
        foreach ($this->getFactors() as $factor) {
            $factorsNames[] = $factor->name.' ('.$factor->code.')';
        }

        return $factorsNames;
    }

    public function getPeriodicitiesCombinedNames()
    {
        $periodicitiesNames = [];
        foreach ($this->getCombinedPeriodicities() as $periodicity) {
            $periodicitiesNames[] = $periodicity->name.' ('.$periodicity->getReason().')';
        }

        return $periodicitiesNames;
    }

    public function getFactorsIds()
    {
        return $this->objects_column($this->getFactors(), 'factor_id');
    }

    public function getDoctorsNames()
    {
        return $this->objects_column($this->getCombinedDoctors(), 'name');
    }

    public function getAnalyzesNames()
    {
        return $this->objects_column($this->getCombinedAnalyzes(), 'name');
    }

    public function getCombinedDoctors()
    {
        $factorsDoctors = Doctor::find()
            ->innerJoin('factor_doctor', 'doctor.doctor_id = factor_doctor.doctor_id')
            ->where(['factor_doctor.factor_id' => $this->getFactorsIds()])
            ->all();

        $professionDoctors = Doctor::find()
            ->innerJoin('profession_doctor', 'doctor.doctor_id = profession_doctor.doctor_id')
            ->where(['profession_doctor.profession_id' => $this->profession_id])
            ->all();

        $doctors = [];
        foreach ($factorsDoctors as $doctor) {
            $doctors[ $doctor->doctor_id ] = $doctor;
        }
        foreach ($professionDoctors as $doctor) {
            $doctors[ $doctor->doctor_id ] = $doctor;
        }

        return $doctors;
    }

    public function getCombinedAnalyzes()
    {
        $factorsAnalyzes = Analysis::find()
            ->innerJoin('factor_analysis', 'analysis.analysis_id = factor_analysis.analysis_id')
            ->where(['factor_analysis.factor_id' => $this->getFactorsIds()])
            ->all();

        $professionAnalyzes = Analysis::find()
            ->innerJoin('profession_analysis', 'analysis.analysis_id = profession_analysis.analysis_id')
            ->where(['profession_analysis.profession_id' => $this->profession_id])
            ->all();

        $analyzes = [];
        foreach ($factorsAnalyzes as $analysis) {
            $analyzes[ $analysis->analysis_id ] = $analysis;
        }
        foreach ($professionAnalyzes as $analysis) {
            $analyzes[ $analysis->analysis_id ] = $analysis;
        }

        return $analyzes;
    }

    public function getCombinedPeriodicities()
    {
        $indexedFactors = $this->getIndexedFactors();

        $factorsPeriodicitiesMap = FactorPeriodicity::find()
            ->where(['factor_id' => array_keys($indexedFactors)])
            ->all();

        $indexedFactorsPeriodicitiesMap = [];
        foreach ($factorsPeriodicitiesMap as $factorPeriodicity) {
            $indexedFactorsPeriodicitiesMap[ $factorPeriodicity->periodicity_id ][] =
                $indexedFactors[ $factorPeriodicity->factor_id ]->name;
        }

        $factorsPeriodicities = Periodicity::find()
            ->where(['periodicity_id' => array_keys($indexedFactorsPeriodicitiesMap)])
            ->all();

        $professionPeriodicities = Periodicity::find()
            ->innerJoin('profession_periodicity', 'periodicity.periodicity_id = profession_periodicity.periodicity_id')
            ->where(['profession_periodicity.profession_id' => $this->profession_id])
            ->all();

        $periodicities = [];
        foreach ($professionPeriodicities as $periodicity) {
            $periodicity->setReason($this->getProfession()->name);
            $periodicities[ $periodicity->periodicity_id ] = $periodicity;
        }
        foreach ($factorsPeriodicities as $periodicity) {
            $reason = implode(', ', $indexedFactorsPeriodicitiesMap[ $periodicity->periodicity_id ]);
            if (isset($periodicities[ $periodicity->periodicity_id ])) {
                $reason = $periodicities[ $periodicity->periodicity_id ]->getReason().', '.$reason;
            }

            $periodicity->setReason($reason);
            $periodicities[ $periodicity->periodicity_id ] = $periodicity;
        }

        return $periodicities;
    }
}
