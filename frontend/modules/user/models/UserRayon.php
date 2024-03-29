<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_rayon".
 *
 * @property int|null $rayon_id
 * @property int|null $post_id
 * @property int|null $city_id
 */
class UserRayon extends \yii\db\ActiveRecord
{

    public function getPosts()
    {
        return $this->hasOne(Posts::class, ['id' => 'post_id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_rayon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rayon_id', 'post_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rayon_id' => 'Район',
            'post_id' => 'Post ID',
            'city_id' => 'City ID',
        ];
    }
}
