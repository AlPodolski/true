<?php

namespace frontend\modules\user\models;

use common\models\HairColor;
use common\models\IntimHair;
use common\models\National;
use common\models\Osobenosti;
use common\models\Place;
use common\models\Rayon;
use common\models\Service;
use common\models\Sites;
use frontend\models\Files;
use frontend\models\Metro;
use frontend\models\UserMetro;
use Yii;

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
 * @property int|null $price
 * @property int|null $age
 * @property int|null $rost
 * @property int|null $breast
 * @property int|null $ves
 * @property int|null $check_photo_status
 */
class Posts extends \yii\db\ActiveRecord
{

    const INDI_CATEGORY = 1;
    const SALON_CATEGORY = 2;

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
            [['city_id', 'user_id', 'created_at', 'updated_at', 'category', 'check_photo_status', 'price', 'age', 'rost', 'ves'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['phone'], 'string', 'max' => 20],
            [['video'], 'string', 'max' => 122],
        ];
    }

    public function getAvatar()
    {
        return $this->hasOne(Files::class, ['related_id' => 'id'])->andWhere(['related_class' => self::class])
            ->andWhere(['main' => 1])->cache(3600);
    }
    public function getAllPhoto()
    {
        return $this->hasMany(Files::class, ['related_id' => 'id'])->andWhere(['related_class' => self::class])->cache(3600;
    }

    public function getSelphiCount()
    {
        return $this->hasMany(Files::class, ['related_id' => 'id'])
            ->andWhere(['related_class' => self::class])->cache(3600
            ->andWhere(['type' => Files::SELPHY_TYPE]);
    }
    public function getMetro()
    {
        return $this->hasMany(Metro::class, ['id' => 'metro_id'])->via('userToMetroRelations')->cache(3600;
    }

    public function getPlace()
    {
        return $this->hasMany(Place::class, ['id' => 'place_id'])->via('userToPlaceRelations')->cache(3600;
    }

    public function getUserToPlaceRelations()
    {
        return $this->hasMany(UserPlace::class, ['post_id' => 'id'])->cache(3600);
    }


    public function getRayon()
    {
        return $this->hasMany(Rayon::class, ['id' => 'rayon_id'])->via('userToRayonRelations');
    }

    public function getUserToRayonRelations()
    {
        return $this->hasMany(UserRayon::class, ['post_id' => 'id']);
    }

    public function getNacionalnost()
    {
        return $this->hasMany(National::class, ['id' => 'national_id'])->via('userToNacionalnostRelations');
    }

    public function getUserToNacionalnostRelations()
    {
        return $this->hasMany(UserNational::class, ['post_id' => 'id']);
    }

    public function getCvet()
    {
        return $this->hasMany(HairColor::class, ['id' => 'hair_color_id'])->via('userToCvetRelations');
    }

    public function getUserToCvetRelations()
    {
        return $this->hasMany(UserHairColor::class, ['post_id' => 'id']);
    }

    public function getStrizhka()
    {
        return $this->hasMany(IntimHair::class, ['id' => 'color_id'])->via('userToStrizhkaRelations');
    }

    public function getUserToStrizhkaRelations()
    {
        return $this->hasMany(UserIntimHair::class, ['post_id' => 'id']);
    }

    public function getOsobenost()
    {
        return $this->hasMany(Osobenosti::class, ['id' => 'param_id'])->via('userToOsobenostRelations');
    }

    public function getUserToOsobenostRelations()
    {
        return $this->hasMany(UserOsobenosti::class, ['post_id' => 'id']);
    }

    public function getService()
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])->via('userToServiceRelations');
    }

    public function getSites()
    {
        return $this->hasMany(PostSites::class, ['post_id' => 'id'])->with('site');
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

        $data = Yii::$app->cache->get('count_photo'.$id);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = Files::find()->where(['related_class' => self::class])->andWhere(['related_id' => $id])->count();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('count_photo'.$id, $data);
        }

        return $data;

    }

    public static function countReview($id)
    {

        $data = Yii::$app->cache->get('review_count_'.$id);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = Review::find()->where(['post_id' => $id])->count();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('review_count_'.$id, $data);
        }

        return $data;

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
