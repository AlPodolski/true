<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "osobenosti".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $value
 * @property string|null $value2
 * @property string|null $value3
 */
class Osobenosti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'osobenosti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'value', 'value2', 'value3'], 'string', 'max' => 50],
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
        $data = Yii::$app->cache->get('osobenosti_list');

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = self::find()->asArray()->orderBy('value ASC')->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('osobenosti_list', $data);
        }

        return $data;
    }
}
