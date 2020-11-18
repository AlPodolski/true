<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_service".
 *
 * @property int|null $post_id
 * @property int|null $service_id
 */
class UserService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'service_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'service_id' => 'Service ID',
        ];
    }
}
