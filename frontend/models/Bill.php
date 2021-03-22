<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $status 0 Счет выставлен, ожидает оплаты, 1 Счет оплачен , 2 Счет отклонен , 3 Время жизни счета истекло. Счет не оплачен
 * @property int|null $sum
 */
class Bill extends \yii\db\ActiveRecord
{

    const WAITING = 0;
    const PAID = 1;
    const REJECTED = 2;
    const EXPIRED = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'sum'], 'integer'],
            [['user_id', 'status', 'sum'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'sum' => 'Sum',
        ];
    }
}
