<?php

namespace cabinet\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_hair_color".
 *
 * @property int|null $post_id
 * @property int|null $hair_color_id
 * @property int|null $city_id
 */
class UserHairColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_hair_color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'hair_color_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'hair_color_id' => 'Цвет волос',
            'city_id' => 'City ID',
        ];
    }
}
