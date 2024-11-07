<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "obmenka_currency".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 * @property int $payment_system
 */
class ObmenkaCurrency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obmenka_currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
}
