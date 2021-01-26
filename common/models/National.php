<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "national".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $value
 */
class National extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'national';
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
        ];
    }

    public static function getAll()
    {
        $data = Yii::$app->cache->get('naci_list');

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = National::find()->asArray()->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('naci_list', $data);
        }

        return $data;
    }

}
