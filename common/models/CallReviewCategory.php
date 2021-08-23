<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "call_review_category".
 *
 * @property int $id
 * @property string|null $value
 * @property int|null $marc числовое значение категории отзыва
 */
class CallReviewCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_review_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['marc'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'marc' => 'Marc',
        ];
    }
}
