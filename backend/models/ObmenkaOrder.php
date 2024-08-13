<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ObmenkaOrder as ObmenkaOrderModel;

/**
 * ObmenkaOrder represents the model behind the search form of `common\models\ObmenkaOrder`.
 */
class ObmenkaOrder extends ObmenkaOrderModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'sum', 'created_at', 'status', 'pay_info', 'user_to'], 'integer'],
            [['tracking_id'], 'safe'],
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
        $query = ObmenkaOrderModel::find();

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
            'user_id' => $this->user_id,
            'sum' => $this->sum,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'pay_info' => $this->pay_info,
            'user_to' => $this->user_to,
            'tracking_id' => trim($this->tracking_id),
        ]);

        $query->andFilterWhere(['like', 'tracking', $this->tracking]);

        return $dataProvider;
    }
}
