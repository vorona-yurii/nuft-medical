<?php

namespace app\models\search;

use app\models\Report;
use yii\data\ActiveDataProvider;

class ReportSearch extends Report
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'report_id' ], 'integer' ],
            [ [ 'name'], 'string' ],
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
            'sort'       => [ 'defaultOrder' => [ 'report_id' => SORT_ASC ] ],
            'pagination' => [
                'defaultPageSize' => '15',
            ],
        ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            return $dataProvider;
        }

        if($this->name) {
            $query->andFilterWhere( ['like', 'name', $this->name] );
        }

        return $dataProvider;
    }
}