<?php

namespace common\models;
use frontend\modules\user\models\Posts;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "phone_advert_view_stat".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $last_view
 * @property int|null $count_view
 *
 * @property Posts $post
 */
class PhoneAdvertViewStat extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => false,
                    self::EVENT_BEFORE_UPDATE => ['last_view', false],
                ],
                // если вместо метки времени UNIX используется datetime:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phone_advert_view_stat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'last_view', 'count_view'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['post_id' => 'id']],
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
            'last_view' => 'Last View',
            'count_view' => 'Count View',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::class, ['id' => 'post_id']);
    }
}
