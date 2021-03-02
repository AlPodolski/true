<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_osobenosti".
 *
 * @property int|null $post_id
 * @property int|null $param_id
 * @property int|null $city_id
 */
class UserOsobenosti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_osobenosti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'param_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'param_id' => 'Особености',
            'city_id' => 'City ID',
        ];
    }
}
