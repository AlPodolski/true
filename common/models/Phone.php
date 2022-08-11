<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "phone".
 *
 * @property int $id
 * @property string|null $phone
 * @property int|null $created_at
 */
class Phone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phone';
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['phone'], 'string', 'max' => 255],
            [['phone'], 'unique'],
            [['phone'], 'validatePhone'],
        ];
    }

    public function validatePhone($attribute)
    {
        if (!$this->hasErrors()) {
            $this->phone = preg_replace('/[^0-9]/', '', $this->phone);
        }
    }

    public function getComments(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Comments::class, ['related_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'created_at' => 'Created At',
        ];
    }
}
