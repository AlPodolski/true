<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rost".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $value
 * @property string|null $value2
 */
class Rost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rost';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'value', 'value2'], 'string', 'max' => 255],
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
            'value2' => 'Value2',
        ];
    }

    public static function getData()
    {
        $data = Yii::$app->cache->get('rost_list');

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = self::find()->orderBy('value ASC')->asArray()->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('rost_list', $data);
        }

        return $data;
    }

}
