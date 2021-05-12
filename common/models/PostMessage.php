<?php

namespace common\models;

use frontend\modules\user\models\Posts;

use Yii;

/**
 * This is the model class for table "post_message".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $status
 * @property string|null $message
 *
 * @property Posts $post
 */
class PostMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'status'], 'integer'],
            [['message'], 'string'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
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
            'status' => 'Status',
            'message' => 'Сообщение',
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
}
