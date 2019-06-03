<?php

namespace app\models\search;

use app\models\Profession;
use yii\data\ActiveDataProvider;

class ProfessionSearch extends Profession
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ [ 'profession_id' ], 'integer' ],
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
            'sort'       => [ 'defaultOrder' => [ 'profession_id' => SORT_ASC ] ],
            'pagination' => [
                'defaultPageSize' => '15',
            ],
        ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            return $dataProvider;
        }

        if($this->profession_id) {
            $query->andFilterWhere( ['profession_id' => $this->profession_id] );
        }

        if($this->name) {
            $query->andFilterWhere( ['like', 'name', $this->name] );
        }

        if($this->code) {
            $query->andFilterWhere( ['like', 'code', $this->code] );
        }

        return $dataProvider;
    }
}