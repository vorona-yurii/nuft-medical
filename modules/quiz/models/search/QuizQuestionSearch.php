<?php

namespace app\modules\quiz\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quiz\models\QuizQuestion;

/**
 * QuizQuestionSearch represents the model behind the search form of `app\modules\quiz\models\QuizQuestion`.
 */
class QuizQuestionSearch extends QuizQuestion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_question_id', 'quiz_subject_id', 'level'], 'integer'],
            [['type', 'image', 'content', 'explanation', 'references'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = QuizQuestion::find();

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
            'quiz_question_id' => $this->quiz_question_id,
            'quiz_subject_id' => $this->quiz_subject_id,
            'level' => $this->level,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'explanation', $this->explanation])
            ->andFilterWhere(['like', 'references', $this->references]);

        return $dataProvider;
    }
}
