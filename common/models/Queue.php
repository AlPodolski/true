<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "queue".
 *
 * @property int $id
 * @property string $channel
 * @property resource $job
 * @property int $pushed_at
 * @property int $ttr
 * @property int $delay
 * @property int $priority
 * @property int|null $reserved_at
 * @property int|null $attempt
 * @property int|null $done_at
 */
class Queue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel', 'job', 'pushed_at', 'ttr'], 'required'],
            [['job'], 'string'],
            [['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at'], 'integer'],
            [['channel'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'job' => 'Job',
            'pushed_at' => 'Pushed At',
            'ttr' => 'Ttr',
            'delay' => 'Delay',
            'priority' => 'Priority',
            'reserved_at' => 'Reserved At',
            'attempt' => 'Attempt',
            'done_at' => 'Done At',
        ];
    }
}
