<?php

namespace frontend\modules\user\models;

use common\models\Place;
use common\models\Service;
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
 * @property string|null $video
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
            [['video'], 'string', 'max' => 122],
        ];
    }

    public function getAvatar()
    {
        return $this->hasOne(Files::class, ['related_id' => 'id'])->andWhere(['related_class' => self::class])
            ->andWhere(['main' => 1]);
    }
    public function getAllPhoto()
    {
        return $this->hasMany(Files::class, ['related_id' => 'id'])->andWhere(['related_class' => self::class]);
    }

    public function getMetro()
    {
        return $this->hasMany(Metro::class, ['id' => 'metro_id'])->via('userToMetroRelations');
    }

    public function getPlace()
    {
        return $this->hasMany(Place::class, ['id' => 'place_id'])->via('userToPlaceRelations');
    }

    public function getUserToPlaceRelations()
    {
        return $this->hasMany(UserPlace::class, ['post_id' => 'id']);
    }

    public function getService()
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])->via('userToServiceRelations');
    }

    public function getUserToServiceRelations()
    {
        return $this->hasMany(UserService::class, ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserToMetroRelations()
    {
        return $this->hasMany(UserMetro::class, ['post_id' => 'id']);
    }

    public static function countPhoto($id)
    {
        return Files::find()->where(['related_class' => self::class])->andWhere(['related_id' => $id])->count();
    }

    public static function countReview($id)
    {
        return Review::find()->where(['post_id' => $id])->count();
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
