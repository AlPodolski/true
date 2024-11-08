<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $city
 * @property string|null $city2
 * @property string|null $city3
 * @property string|null $country
 * @property string|null $x
 * @property string|null $y
 * @property string|null $actual_city
 * @property string|null $domain
 * @property string|null $external_domain
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'city', 'city2', 'city3', 'country', 'domain', 'actual_city', 'external_domain'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'city' => 'CurrentCity',
            'city2' => 'City2',
            'city3' => 'City3',
            'actual_city' => 'Основа',
            'external_domain' => 'Внешка',
        ];
    }

    public static function getCity($city){

        $data = Yii::$app->cache->get('city_info_'.$city);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = City::find()->where(['url' => $city])->orWhere(['city' => $city])->asArray()->one();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('city_info_'.$city, $data);
        }

        return $data;

    }
}
