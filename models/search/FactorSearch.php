<?php

namespace app\models\search;

use app\models\Factor;
use yii\data\ActiveDataProvider;

class FactorSearch extends Factor
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'factor_id' ], 'integer' ],
            [ [ 'name', 'code' ], 'string' ],
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
            'sort'       => [ 'defaultOrder' => [ 'factor_id' => SORT_ASC ] ],
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

        if($this->code) {
            $query->andFilterWhere( ['code' => $this->code] );
        }

        return $dataProvider;
    }
}