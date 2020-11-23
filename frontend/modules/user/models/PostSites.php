<?php

namespace frontend\modules\user\models;

use common\models\Sites;
use Yii;

/**
 * This is the model class for table "post_sites".
 *
 * @property int|null $id
 * @property int|null $post_id
 * @property int|null $site_id
 * @property int|null $price
 * @property int|null $created_at
 * @property int|null $age
 * @property string|null $name_on_site
 */
class PostSites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_sites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'site_id', 'price', 'created_at', 'age', 'id'], 'integer'],
            [['name_on_site'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'site_id' => 'Site ID',
            'price' => 'Price',
            'created_at' => 'Created At',
        ];
    }

    public function getSite()
    {
        return $this->hasOne(Sites::class, ['id' => 'site_id'])->with('photo');
    }

}
