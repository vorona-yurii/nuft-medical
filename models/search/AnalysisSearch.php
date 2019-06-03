<?php

namespace app\models\search;

use app\models\Analysis;
use yii\data\ActiveDataProvider;

class AnalysisSearch extends Analysis
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'analysis_id' ], 'integer' ],
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
            'sort'       => [ 'defaultOrder' => [ 'analysis_id' => SORT_ASC ] ],
            'pagination' => [
                'defaultPageSize' => '15',
            ],
        ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            return $dataProvider;
        }

        if($this->analysis_id) {
            $query->andFilterWhere( ['analysis_id' => $this->analysis_id] );
        }

        if($this->name) {
            $query->andFilterWhere( ['like', 'name', $this->name] );
        }

        return $dataProvider;
    }
}