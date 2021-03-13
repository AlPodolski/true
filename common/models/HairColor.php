<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hair_color".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $value
 * @property string|null $value2
 * @property string|null $value3
 */
class HairColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hair_color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'value'], 'string', 'max' => 50],
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
            'value3' => 'Value3',
        ];
    }

    public static function getAll()
    {
        $data = Yii::$app->cache->get('hair_list');

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = HairColor::find()->orderBy('value ASC')->asArray()->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('hair_list', $data);
        }

        return $data;
    }
}
