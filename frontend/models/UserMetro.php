<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_metro".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $metro_id
 * @property int|null $city_id
 */
class UserMetro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_metro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'city_id'], 'integer'],
            [['metro_id'], 'validateMetroId'],
        ];
    }

    public function validateMetroId()
    {
        if (is_array($this->metro_id)) $this->metro_id = array_slice($this->metro_id, 0, 4);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'metro_id' => 'Метро',
        ];
    }
}
