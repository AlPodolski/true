<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_national".
 *
 * @property int|null $post_id
 * @property int|null $national_id
 * @property int|null $city_id
 */
class UserNational extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_national';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'national_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'User ID',
            'national_id' => 'National ID',
            'city_id' => 'City ID',
        ];
    }
}
