<?php

namespace frontend\modules\user\models;

use common\models\Service;
use Yii;

/**
 * This is the model class for table "user_service".
 *
 * @property int|null $post_id
 * @property int|null $service_id
 * @property int|null $city_id
 * @property string|null $service_info
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
            [['post_id', 'service_id', 'city_id'], 'integer'],
            [['service_info'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'service_id' => 'Услуги',
            'service_info' => 'Описание услуги',
        ];
    }

    public function getPost()
    {
        return $this->hasMany(Posts::class, ['id' => 'post_id']);
    }

    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

}
