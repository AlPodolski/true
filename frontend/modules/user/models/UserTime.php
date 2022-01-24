<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_time".
 *
 * @property int $id
 * @property int|null $param_id
 * @property int|null $post_id
 * @property int|null $city_id
 */
class UserTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['param_id', 'post_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param_id' => 'Param ID',
            'post_id' => 'Post ID',
        ];
    }
}
