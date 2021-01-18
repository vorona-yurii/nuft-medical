<?php

namespace app\modules\quiz\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quiz\models\QuizEmployee;

/**
 * QuizEmployeeSearch represents the model behind the search form of `app\modules\quiz\models\QuizEmployee`.
 */
class QuizEmployeeSearch extends QuizEmployee
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_employee_id', 'employee_id', 'passed', 'start_date', 'end_date', 'score'], 'integer'],
            [['token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param integer $quiz_id
     *
     * @return ActiveDataProvider
     */
    public function search($params, $quiz_id)
    {
        $query = QuizEmployee::find()->where(['quiz_id' => $quiz_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'quiz_employee_id' => $this->quiz_employee_id,
            'employee_id' => $this->employee_id,
            'passed' => $this->passed,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'score' => $this->score,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
