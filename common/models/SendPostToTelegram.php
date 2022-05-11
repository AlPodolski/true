<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "send_post_to_telegram".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $created_at
 * @property int|null $job_id
 * @property int|null $status
 */
class SendPostToTelegram extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'send_post_to_telegram';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'created_at', 'job_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'created_at' => 'Created At',
            'job_id' => 'Job ID',
            'status' => 'Status',
        ];
    }
}
