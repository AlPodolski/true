<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FilterParams as FilterParamsModel;

/**
 * FilterParams represents the model behind the search form of `common\models\FilterParams`.
 */
class FilterParams extends FilterParamsModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['url', 'class_name', 'relation_class', 'column_param_name', 'short_name'], 'safe'],
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
        $query = FilterParamsModel::find();

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
            ->andFilterWhere(['like', 'class_name', $this->class_name])
            ->andFilterWhere(['like', 'relation_class', $this->relation_class])
            ->andFilterWhere(['like', 'column_param_name', $this->column_param_name])
            ->andFilterWhere(['like', 'short_name', $this->short_name]);

        return $dataProvider;
    }
}
