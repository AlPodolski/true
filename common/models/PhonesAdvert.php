<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "phones_advert".
 *
 * @property int $id
 * @property string|null $phone
 * @property int|null $price
 * @property int|null $view
 * @property int|null $last_view
 * @property int $city_id
 * @property City $city
 */
class PhonesAdvert extends \yii\db\ActiveRecord
{

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
            [['price', 'view', 'last_view', 'city_id'], 'integer'],
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
        ];
    }
}
