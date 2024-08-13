<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "obmenka_order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $sum
 * @property string|null $tracking
 * @property int|null $created_at
 * @property int|null $status
 * @property int|null $user_to
 * @property int|null $pay_info
 * @property string $link
 * @property string $tracking_id
 */
class ObmenkaOrder extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }

    const WAIT = 1;
    const FINISH = 2;

    const BUY_VIP = 1;
    const GIFT_VIP = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obmenka_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'sum', 'created_at', 'status', 'user_to', 'pay_info'], 'integer'],
            [['tracking'], 'string', 'max' => 40],
            [['tracking_id'], 'string', 'max' => 40],
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
            'sum' => 'Sum',
            'tracking_id' => 'Tracking',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
