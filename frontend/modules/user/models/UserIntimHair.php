<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_intim_hair".
 *
 * @property int|null $post_id
 * @property int|null $color_id
 * @property int|null $city_id
 */
class UserIntimHair extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_intim_hair';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'color_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'color_id' => 'Color ID',
            'city_id' => 'City ID',
        ];
    }
}
