<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "top_anket_block".
 *
 * @property int|null $post_id
 * @property int|null $city_id
 * @property int|null $valid_to
 */
class TopAnketBlock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'top_anket_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'city_id', 'valid_to'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'city_id' => 'City ID',
            'valid_to' => 'Valid To',
        ];
    }
}
