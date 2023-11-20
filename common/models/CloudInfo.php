<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cloud_info".
 *
 * @property int $id
 * @property string|null $zone
 */
class CloudInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cloud_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zone' => 'Zone',
        ];
    }
}
