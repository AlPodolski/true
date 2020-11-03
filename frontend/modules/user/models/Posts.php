<?php

namespace frontend\modules\user\models;

use frontend\models\Files;
use frontend\models\Metro;
use frontend\models\UserMetro;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int|null $city_id
 * @property int|null $user_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $about
 * @property int|null $category
 * @property int|null $selfie
 * @property int|null $check_photo_status
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'user_id', 'created_at', 'updated_at', 'category', 'selfie', 'check_photo_status'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['phone'], 'string', 'max' => 20],
            [['about'], 'string', 'max' => 255],
        ];
    }

    public function getAvatar()
    {
        return $this->hasOne(Files::class, ['related_id' => 'id'])->andWhere(['related_class' => self::class])
            ->andWhere(['main' => 1]);
    }

    public function getMetro()
    {
        return $this->hasMany(Metro::class, ['id' => 'metro_id'])->via('userToMetroRelations');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserToMetroRelations()
    {
        return $this->hasMany(UserMetro::class, ['post_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'phone' => 'Phone',
            'about' => 'About',
            'category' => 'Category',
            'selfie' => 'Selfie',
            'check_photo_status' => 'Check Photo Status',
        ];
    }
}
