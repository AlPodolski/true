<?php

namespace frontend\models;

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
}
