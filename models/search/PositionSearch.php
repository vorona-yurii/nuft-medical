<?php

namespace app\models\search;

use app\models\Position;
use yii\data\ActiveDataProvider;

class PositionSearch extends Position
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'position_id' ], 'integer' ],
            [ [ 'name', 'profession_id', 'department_id' ], 'string' ],
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
            'sort'       => [ 'defaultOrder' => [ 'position_id' => SORT_ASC ] ],
            'pagination' => [
                'defaultPageSize' => '15',
            ],
        ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            return $dataProvider;
        }

        if($this->name) {
            $query->andFilterWhere( ['name' => $this->name] );
        }

        if($this->profession_id) {
            $query->andFilterWhere( ['profession_id' => $this->profession_id] );
        }

        if($this->department_id) {
            $query->andFilterWhere( ['department_id' => $this->department_id] );
        }

        return $dataProvider;
    }
}