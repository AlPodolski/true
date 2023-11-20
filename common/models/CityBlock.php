<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "city_block".
 *
 * @property int $id
 * @property int|null $city_id
 * @property string|null $old_city
 * @property string|null $new_city
 * @property int|null $created_at
 */
class CityBlock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'created_at'], 'integer'],
            [['old_city', 'new_city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'old_city' => 'Old City',
            'new_city' => 'New City',
            'created_at' => 'Created At',
        ];
    }
}
