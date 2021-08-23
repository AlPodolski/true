<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "phone_review".
 *
 * @property int $id
 * @property int|null $phone_id
 * @property int|null $call_category_id
 * @property int|null $text
 * @property int|null $created_at
 */
class PhoneReview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phone_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_id', 'call_category_id', 'created_at'], 'integer'],
            [['text'], 'string']
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    public function getMarc()
    {
        return $this->hasOne(CallReviewCategory::class, ['id' => 'call_category_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone_id' => 'Phone ID',
            'call_category_id' => 'Call Category ID',
            'text' => 'Text',
        ];
    }
}
