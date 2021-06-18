<?php

namespace common\models;

use frontend\modules\user\models\Posts;

use Yii;

/**
 * This is the model class for table "anket_claim".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $reason_id
 * @property string|null $text
 *
 * @property Posts $post
 * @property ReasonClaim $reason
 */
class AnketClaim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anket_claim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'reason_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['reason_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReasonClaim::className(), 'targetAttribute' => ['reason_id' => 'id']],
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
            'reason_id' => 'Reason ID',
            'text' => 'Text',
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
     * Gets query for [[Reason]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(ReasonClaim::className(), ['id' => 'reason_id']);
    }
}
