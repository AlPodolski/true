<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\City;

/**
 * CitySearch represents the model behind the search form of `common\models\City`.
 */
class CitySearch extends City
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['url', 'city', 'city2', 'city3', 'country', 'x', 'y', 'actual_city'], 'safe'],
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
        $query = City::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'city2', $this->city2])
            ->andFilterWhere(['like', 'city3', $this->city3])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'x', $this->x])
            ->andFilterWhere(['like', 'y', $this->y])
            ->andFilterWhere(['like', 'actual_city', $this->actual_city]);

        return $dataProvider;
    }
}
