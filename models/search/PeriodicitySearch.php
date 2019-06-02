<?php

namespace app\models\search;

use app\models\Periodicity;
use yii\data\ActiveDataProvider;

class PeriodicitySearch extends Periodicity
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'periodicity_id' ], 'integer' ],
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
            'sort'       => [ 'defaultOrder' => [ 'periodicity_id' => SORT_ASC ] ],
            'pagination' => [
                'defaultPageSize' => '15',
            ],
        ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            return $dataProvider;
        }

        if($this->periodicity_id) {
            $query->andFilterWhere( ['periodicity_id' => $this->periodicity_id] );
        }

        if($this->name) {
            $query->andFilterWhere( ['name' => $this->name] );
        }

        return $dataProvider;
    }
}