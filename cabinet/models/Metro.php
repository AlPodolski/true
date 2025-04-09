<?php

namespace cabinet\models;

use cabinet\modules\user\models\Review;
use cabinet\modules\user\models\UserRayon;
use Yii;

/**
 * This is the model class for table "metro".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $value
 * @property string|null $value2
 * @property string|null $value3
 * @property int|null $city_id
 * @property float|null $x
 * @property float|null $y
 */
class Metro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['url', 'value', 'value2', 'value3'], 'string', 'max' => 50],
        ];
    }

    public function getPosts()
    {
        return $this->hasMany(UserMetro::class, ['metro_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'value' => 'Value',
            'value2' => 'Value2',
            'value3' => 'Value3',
            'city_id' => 'City ID',
        ];
    }

    public static function getMetro($cityId)
    {
        $data = Yii::$app->cache->get('metro_'.$cityId);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = Metro::find()->where(['city_id' => $cityId])->asArray()->orderBy('value')->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('metro_'.$cityId, $data);
        }

        return $data;
    }

    public static function getByUrl($url, $cityId)
    {

        $data = Yii::$app->cache->get('metro_url_'.$url.'_'.$cityId);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = Metro::find()->where(['url' => $url, 'city_id' => $cityId])->one();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('metro_url_'.$url.'_'.$cityId, $data);
        }

        return $data;
    }

}
