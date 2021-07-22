<?php

namespace common\models;

use frontend\modules\advert\models\Advert;
use Yii;

/**
 * This is the model class for table "advert_category".
 *
 * @property int $id
 * @property string|null $value
 *
 * @property Advert[] $adverts
 */
class AdvertCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advert_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }

    /**
     * Gets query for [[Adverts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdverts()
    {
        return $this->hasMany(Advert::class, ['category_id' => 'id']);
    }
}
