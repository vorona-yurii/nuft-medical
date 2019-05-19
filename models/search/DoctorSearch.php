<?php

namespace app\models\search;

use app\models\Doctor;
use yii\data\ActiveDataProvider;

class DoctorSearch extends Doctor
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'doctor_id' ], 'integer' ],
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
            'sort'       => [ 'defaultOrder' => [ 'doctor_id' => SORT_ASC ] ],
            'pagination' => [
                'defaultPageSize' => '15',
            ],
        ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            return $dataProvider;
        }

        if($this->doctor_id) {
            $query->andFilterWhere( ['doctor_id' => $this->doctor_id] );
        }

        if($this->name) {
            $query->andFilterWhere( ['name' => $this->name] );
        }

        return $dataProvider;
    }
}