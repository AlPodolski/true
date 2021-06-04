<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "telegram_last_update".
 *
 * @property int $id
 * @property int|null $update_id id последнего обновления в боте
 */
class TelegramLastUpdate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_last_update';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['update_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'update_id' => 'Update ID',
        ];
    }
}
