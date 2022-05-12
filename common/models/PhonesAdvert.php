<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "phones_advert".
 *
 * @property int $id
 * @property string|null $phone
 * @property int|null $price
 * @property int|null $view
 * @property int|null $last_view
 * @property int $city_id
 * @property int $status
 * @property int $created_at
 * @property City $city
 */
class PhonesAdvert extends \yii\db\ActiveRecord
{

    const DONT_PUBLICATION_STATUS = 0;
    const PUBLICATION_STATUS = 1;


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', false],
                    self::EVENT_BEFORE_UPDATE => false,
                ],
                // если вместо метки времени UNIX используется datetime:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phones_advert';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'view', 'last_view', 'city_id', 'status', 'created_at'], 'integer'],
            [['phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'price' => 'Price',
            'view' => 'View',
            'last_view' => 'Last View',
            'city_id' => 'City',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
        ];
    }
}
