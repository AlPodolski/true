<?php

namespace common\models;

use frontend\modules\user\models\Posts;
use frontend\modules\user\models\ServiceReviews;
use frontend\modules\user\models\UserService;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string|null $value
 * @property string|null $url
 * @property string|null $value2
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'url', 'value2'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'url' => 'Url',
            'value2' => 'Value2',
        ];
    }

    public function getUserService()
    {
        return $this->hasMany(ServiceReviews::class, ['service_id' => 'id'])->andWhere();
    }

    public function getPosts()
    {
        return $this->hasMany(UserService::class, ['service_id' => 'id']);
    }

}
