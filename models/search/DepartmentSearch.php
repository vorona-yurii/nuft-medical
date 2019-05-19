<?php

namespace app\models\search;

use app\models\Department;
use yii\data\ActiveDataProvider;

class DepartmentSearch extends Department
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'department_id' ], 'integer' ],
            [ [ 'name' ], 'string' ],
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
            'sort'       => [ 'defaultOrder' => [ 'department_id' => SORT_ASC ] ],
            'pagination' => [
                'defaultPageSize' => '15',
            ],
        ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            return $dataProvider;
        }

        if($this->department_id) {
            $query->andFilterWhere( ['department_id' => $this->department_id] );
        }

        if($this->name) {
            $query->andFilterWhere( ['name' => $this->name] );
        }

        return $dataProvider;
    }
}