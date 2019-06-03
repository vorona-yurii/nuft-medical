<?php

namespace app\models\search;

use app\models\Employee;
use yii\data\ActiveDataProvider;

class EmployeeSearch extends Employee
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'employee_id' ], 'integer' ],
            [ [ 'full_name', 'phone' ], 'string' ],
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

        if($this->employee_id) {
            $query->andFilterWhere( ['employee_id' => $this->employee_id] );
        }

        if($this->full_name) {
            $query->andFilterWhere( ['like', 'full_name', $this->full_name] );
        }

        if($this->phone) {
            $query->andFilterWhere( ['like', 'phone', $this->phone] );
        }

        return $dataProvider;
    }
}