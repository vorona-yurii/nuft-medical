<?php

namespace app\models\search;

use app\models\Employee;
use yii\data\ActiveDataProvider;

class ReportEmployeeSearch extends Employee
{
    public $doctor;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'employee_id' ], 'integer' ],
            [ [ 'full_name', 'phone' ], 'string' ],
            [ ['doctor'], 'safe' ]
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search( $params )
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider( [
            'query'      => $query,
            'sort'       => [ 'defaultOrder' => [ 'employee_id' => SORT_ASC ] ],
            'pagination' => [
                'defaultPageSize' => '15',
            ],
        ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            return $dataProvider;
        }

        if($this->full_name) {
            $query->andFilterWhere( ['full_name' => $this->full_name] );
        }

        return $dataProvider;
    }
}