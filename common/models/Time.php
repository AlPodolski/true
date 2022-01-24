<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "time".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $value
 */
class Time extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'value'], 'string', 'max' => 255],
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
            'value' => 'Value',
        ];
    }

    public static function getTime()
    {
        $data = Yii::$app->cache->get('time_list');

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = self::find()->orderBy('value ASC')->asArray()->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('place_list', $data);
        }

        return $data;
    }

}
