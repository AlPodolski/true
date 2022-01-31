<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tarif".
 *
 * @property int $id
 * @property string|null $value
 * @property int|null $sum
 */
class Tarif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sum'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'sum' => 'Sum',
        ];
    }

    public static function getAll()
    {
        $data = Yii::$app->cache->get(self::tableName().'_list');

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = self::find()->orderBy('sum DESC')->asArray()->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set(self::tableName().'_list', $data);
        }

        return $data;
    }

}
