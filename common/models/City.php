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
            [['url', 'city', 'city2', 'city3', 'country'], 'string', 'max' => 50],
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
