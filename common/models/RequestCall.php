<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "request_call".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $post_id
 * @property int|null $user_id
 * @property string|null $text
 * @property string|null $phone
 * @property int|null $status 0 заявка не просмотрена, 1 просмотрена, 2 заявка скрыта
 */
class RequestCall extends \yii\db\ActiveRecord
{

    const REQUEST_NOT_VIEW = 0;
    const REQUEST_VIEW = 1;
    const REQUEST_HIDE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_call';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'post_id', 'user_id', 'status'], 'integer'],
            [['text', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'phone' => 'Phone',
            'status' => 'Status',
        ];
    }
}
