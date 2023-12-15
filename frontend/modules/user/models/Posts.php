<?php

namespace frontend\modules\user\models;

use common\models\City;
use common\models\HairColor;
use common\models\IntimHair;
use common\models\National;
use common\models\Osobenosti;
use common\models\Place;
use common\models\PostMessage;
use common\models\Rayon;
use common\models\Service;
use common\models\Sites;
use common\models\Tarif;
use frontend\components\helpers\GetOrderHelper;
use frontend\components\service\AddPost;
use frontend\models\Files;
use frontend\models\Metro;
use frontend\models\UserMetro;
use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use frontend\components\service\AddPhoneService;

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
 * @property string|null $old_url
 * @property int|null $category
 * @property int|null $price
 * @property int|null $express_price
 * @property int|null $price_2_hour
 * @property int|null $price_night
 * @property int|null $age
 * @property int|null $rost
 * @property int|null $breast
 * @property int|null $ves
 * @property int|null $check_photo_status
 * @property int|null $status
 * @property int|null $rating
 * @property int|null $view
 * @property int|null $retouching_photo_status
 * @property int|null $likes
 * @property int $advert_phone_view_count
 * @property int $last_phone_view_at
 * @property int|null $fake
 * @property int|null $pay_time
 * @property int|null $pol_id
 * @property int|null $sort
 * @property int|null $x
 * @property int|null $y
 * @property int|null $exit_night_price
 * @property int|null $exit_two_hour_price
 * @property int|null $exit_hour_price
 * @property int|null $national_id
 * @property int|null $intim_hair_id
 * @property Files[] $gallery
 * @property Files $avatar
 * @property integer $tarif_id
 * @property City $city
 * @property National $nacionalnost
 * @property Rayon $rayon
 * @property Tarif $tarif
 * @property Review $review
 */
class Posts extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    const INDI_CATEGORY = 1;
    const SALON_CATEGORY = 2;

    const POST_ON_MODARATION_STATUS = 0;
    const POST_ON_PUPLICATION_STATUS = 1;
    const POST_DONT_PUBLICATION_STATUS = 2;
    const RETURNED_FOR_REVISION = 3;

    const ANKET_CHECK = 1;
    const ANKET_NOT_CHECK = 0;

    const NOT_RETOUCHING_PHOTO_STATUS = 1;
    const WITH_RETOUCHING_PHOTO_STATUS = 0;

    const POST_FAKE = 0;
    const POST_REAL = 1;

    const ADD_POST = 'add_post';

    public function __construct()
    {
        $this->on(self::EVENT_AFTER_INSERT, [AddPost::class, 'handle']);
        $this->on(self::EVENT_AFTER_INSERT, [AddPhoneService::class, 'handle']);
        $this->on(self::EVENT_AFTER_UPDATE, [AddPhoneService::class, 'handle']);

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    public static function getOrder(): string
    {
        return (new GetOrderHelper())->get();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'user_id', 'created_at', 'updated_at', 'category', 'check_photo_status', 'price', 'age',
                'rost', 'ves', 'breast', 'status', 'view', 'retouching_photo_status', 'fake', 'pay_time', 'pol_id',
                'sort', 'tarif_id', 'price_night', 'price_2_hour',
                'express_price', 'exit_hour_price', 'exit_two_hour_price', 'exit_night_price', 'national_id',
                'hair_color_id', 'intim_hair_id'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['phone'], 'string', 'max' => 20 ],
            [['x', 'y', 'rayon_id'], 'safe'],
            [['name', 'phone', 'price', 'city_id'],'required'],
            [['video'], 'string', 'max' => 122],
            [['about' , 'old_url'], 'string'],
            [['phone'], 'validatePhone'],
        ];
    }


    public function validatePhone($attribute)
    {
        if (!$this->hasErrors()) {
            $this->phone = preg_replace('/[^0-9]/', '', $this->phone);
        }
    }

    public static function getTopList($cityId)
    {

        $topAnketList = TopAnketBlock::getPostIds($cityId);

        if ($topAnketList) return self::find()->where(['in', 'id', $topAnketList])
            ->with('metro', 'avatar')
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['city_id' => $cityId])
            ->orderBy((new GetOrderHelper())->get())
            ->asArray()
            ->all();

        return false;
    }

    public function getReview(): ActiveQuery
    {
        return $this->hasMany(Review::class, ['post_id' => 'id'])
            ->with('author')
            ->andWhere(['is_moderate' => Review::MODARATE]);
    }

    public function getTarif()
    {
        return $this->hasOne(Tarif::class, ['id' => 'tarif_id']);
    }

    public function getFiles()
    {
        return $this->hasMany(Files::class, ['related_id' => 'id']);
    }

    public function getAvatar() : ActiveQuery
    {
        return $this->hasOne(Files::class, ['related_id' => 'id'])
            ->andWhere(['related_class' => self::class])
            ->andWhere(['main' => Files::MAIN_PHOTO]);
    }

    public function getGallery()
    {
        return $this->hasMany(Files::class, ['related_id' => 'id'])
            ->andWhere(['related_class' => self::class])
            ->andWhere(['in', 'type', [Files::DEFAULT_TYPE, Files::SELPHY_TYPE]])
            ->andWhere(['main' => Files::NOT_MAIN_PHOTO]);
    }

    public function getCheckPhoto() : ActiveQuery
    {
        return $this->hasOne(Files::class, ['related_id' => 'id'])->andWhere(['related_class' => self::class])
            ->andWhere(['type' => Files::CHECK_PHOTO_TYPE]);
    }

    public function getAllPhoto() : ActiveQuery
    {
        return $this->hasMany(Files::class, ['related_id' => 'id'])
            ->andWhere(['type' => Files::DEFAULT_TYPE]);
    }

    public function getMessage() : ActiveQuery
    {
        return $this->hasMany(PostMessage::class, ['post_id' => 'id'])
            ->andWhere(['status' => 0])
            ->orderBy('id DESC');
    }

    public function getPartnerId()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->select('partner_id')->cache(3600);
    }

    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    public function getReadMessage() : ActiveQuery
    {
        return $this->hasMany(PostMessage::class, ['post_id' => 'id'])
            ->andWhere(['status' => 1])
            ->orderBy('id DESC');
    }

    public function getGal() : ActiveQuery
    {
        return $this->hasMany(Files::class, ['related_id' => 'id'])
            ->andWhere(['related_class' => self::class])
            ->andWhere(['type' => Files::DEFAULT_TYPE])
            ->andWhere(['main' => Files::NOT_MAIN_PHOTO]);
    }

    public function getUserAvatar(){

        return ArrayHelper::getValue(Files::find()
            ->where(['main' => 1])
            ->andWhere(['related_id' => $this->id, 'related_class' => Posts::class])
            ->asArray()->one(), 'file');

    }

    public function getUserCheckPhoto(){

        return ArrayHelper::getValue(Files::find()
            ->where(['main' => 0])
            ->andWhere(['related_id' => $this->id, 'related_class' => Posts::class])
            ->andWhere(['type' => Files::CHECK_PHOTO_TYPE])
            ->asArray()->one(), 'file');

    }

    public function getSelphiCount()
    {
        return $this->hasMany(Files::class, ['related_id' => 'id'])
            ->andWhere(['related_class' => self::class])
            ->andWhere(['type' => Files::SELPHY_TYPE]);
    }
    public function getMetro()
    {
        return $this->hasMany(Metro::class, ['id' => 'metro_id'])
            ->via('userToMetroRelations')
            ->cache(3600)
            ;
    }

    public function getPlace()
    {
        return $this->hasMany(Place::class, ['id' => 'place_id'])->via('userToPlaceRelations');
    }

    public function getUserToPlaceRelations()
    {
        return $this->hasMany(UserPlace::class, ['post_id' => 'id']);
    }


    public function getRayon()
    {
        return $this->hasOne(Rayon::class, ['id' => 'rayon_id']);
    }

    public function getNacionalnost(): ActiveQuery
    {
        return $this->hasOne(National::class, ['id' => 'national_id']);
    }

    public function getCvet()
    {
        return $this->hasOne(HairColor::class, ['id' => 'hair_color_id']);
    }

    public function getStrizhka()
    {
        return $this->hasOne(IntimHair::class, ['id' => 'intim_hair_id']);
    }

    public function getOsobenost()
    {
        return $this->hasMany(Osobenosti::class, ['id' => 'param_id'])->via('userToOsobenostRelations');
    }

    public function getService()
    {
        return $this->hasMany(UserService::class, ['post_id' => 'id'])->with('service');
    }

    public function getUserToServiceRelations()
    {
        return $this->hasMany(UserService::class, ['post_id' => 'id']);
    }

    public function getServiceDesc()
    {
        return $this->hasMany(ServiceDesc::class, ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserToMetroRelations()
    {
        return $this->hasMany(UserMetro::class, ['post_id' => 'id'])->cache(3600);
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
            $data = Review::find()->where(['post_id' => $id])->andWhere(['<>', 'text', ''])->count();

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
            'city_id' => 'Город',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'about' => 'О себе',
            'category' => 'Категория',
            'selfie' => 'Selfie',
            'check_photo_status' => 'Статус проверочного фото',
            'age' => 'Возраст',
            'rost' => 'Рост',
            'breast' => 'Грудь',
            'ves' => 'Вес',
            'price' => 'Цена',
            'express_price' => 'Цена за експроесс',
            'price_2_hour' => 'Цена за 2 часа',
            'price_night' => 'Цена за ночь',
            'status' => 'Статус',
            'national_id' => 'Национальность',
            'hair_color_id' => 'Цвет волос',
            'intim_hair_id' => 'Интимная стрижка',
            'rayon_id' => 'Район',
            'retouching_photo_status' => 'Ретуш фото',
            'advert_phone_view_count' => 'Д. клики',
        ];
    }
}
