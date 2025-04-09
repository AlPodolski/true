<?php

namespace cabinet\modules\user\models;

use Yii;

/**
 * This is the model class for table "service_reviews".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $service_id
 * @property int|null $marc
 */
class ServiceReviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'service_id', 'marc'], 'integer'],
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
            'service_id' => 'Service ID',
            'marc' => 'Marc',
        ];
    }
}
