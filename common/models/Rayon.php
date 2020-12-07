<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rayon".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $value
 * @property int|null $city_id
 * @property string|null $value2
 * @property string|null $value3
 */
class Rayon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rayon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['url', 'value'], 'string', 'max' => 75],
            [['value2', 'value3'], 'string', 'max' => 45],
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
            'city_id' => 'City ID',
            'value2' => 'Value2',
            'value3' => 'Value3',
        ];
    }
}
