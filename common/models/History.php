<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $sum
 * @property int|null $type
 * @property int|null $created_at
 * @property int|null $balance
 */
class History extends \yii\db\ActiveRecord
{

    const BALANCE_REPLENISHMENT = 1;
    const UP_ANKET = 2;
    const BUY_VIEW = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'sum', 'type', 'created_at', 'balance'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид операции',
            'user_id' => 'User ID',
            'sum' => 'Сумма',
            'type' => 'Тип',
            'created_at' => 'Дата создания',
            'balance' => 'Баланс',
        ];
    }
}
