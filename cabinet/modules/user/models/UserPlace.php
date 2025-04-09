<?php

namespace cabinet\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_place".
 *
 * @property int|null $post_id
 * @property int|null $place_id
 * @property int|null $city_id
 */
class UserPlace extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'place_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'place_id' => 'Место',
        ];
    }
}
