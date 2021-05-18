<?php

namespace common\models;

use Yii;
use frontend\modules\user\models\Posts;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $user_id
 * @property int|null $type
 * @property int|null $status
 *
 * @property Posts $post
 * @property User $user
 */
class Event extends \yii\db\ActiveRecord
{

    const POST_RETURNED_FOR_REVISION = 1;

    const NOT_READ_EVENT = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'type', 'status'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
