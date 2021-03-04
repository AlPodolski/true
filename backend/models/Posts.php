<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\user\models\Posts as PostsModel;

/**
 * Posts represents the model behind the search form of `frontend\modules\user\models\Posts`.
 */
class Posts extends PostsModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'user_id', 'created_at', 'updated_at', 'category',
                'check_photo_status', 'price', 'age', 'rost', 'breast', 'ves', 'status'], 'integer'],
            [['name', 'phone', 'about', 'video'], 'safe'],
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
        $query = PostsModel::find();

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
            'city_id' => $this->city_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => $this->category,
            'check_photo_status' => $this->check_photo_status,
            'price' => $this->price,
            'age' => $this->age,
            'rost' => $this->rost,
            'breast' => $this->breast,
            'ves' => $this->ves,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'video', $this->video]);

        return $dataProvider;
    }
}
