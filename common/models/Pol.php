<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pol".
 *
 * @property int $id
 * @property string|null $value
 * @property string|null $url
 */
class Pol extends \yii\db\ActiveRecord
{

    const WOMAN_POL = 1;
    const MEN_POL = 2;
    const TRANS_POL = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'url'], 'string', 'max' => 255],
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
            'url' => 'Url',
        ];
    }

    public static function getAll()
    {
        $data = Yii::$app->cache->get('pol_list');

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = self::find()->asArray()->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('pol_list', $data);
        }

        return $data;
    }

}
