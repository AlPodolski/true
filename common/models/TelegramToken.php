<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "telegram_token".
 *
 * @property int $id
 * @property string $token
 * @property int $telegram_user_id
 * @property int $telegram_chat_id
 * @property int|null $token_status статус токе 0 - токен выпущен но не подтвержден 1 токен подтвержден
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class TelegramToken extends \yii\db\ActiveRecord
{

    const TOKEN_STATUS_NOT_ACTIVE = 0;

    const TOKEN_STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_token';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'telegram_user_id', 'telegram_chat_id'], 'required'],
            [['telegram_user_id', 'telegram_chat_id', 'token_status', 'created_at', 'updated_at'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'telegram_user_id' => 'Telegram User ID',
            'telegram_chat_id' => 'Telegram Chat ID',
            'token_status' => 'Token Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
