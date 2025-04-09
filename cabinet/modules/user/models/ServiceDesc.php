<?php

namespace cabinet\modules\user\models;

use Yii;

/**
 * This is the model class for table "service_desc".
 *
 * @property int|null $service_id
 * @property int|null $post_id
 * @property string|null $text
 */
class ServiceDesc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_desc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'post_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service ID',
            'post_id' => 'Post ID',
            'text' => 'Text',
        ];
    }
}
