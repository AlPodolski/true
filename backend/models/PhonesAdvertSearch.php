<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PhonesAdvert;

/**
 * PhonesAdvertSearch represents the model behind the search form of `common\models\PhonesAdvert`.
 */
class PhonesAdvertSearch extends PhonesAdvert
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'view', 'last_view', 'city_id'], 'integer'],
            [['phone'], 'safe'],
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
        $query = PhonesAdvert::find();

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
            'price' => $this->price,
            'view' => $this->view,
            'last_view' => $this->last_view,
            'city_id' => $this->city_id,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
