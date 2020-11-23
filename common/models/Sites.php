<?php

namespace common\models;

use frontend\models\Files;
use Yii;

/**
 * This is the model class for table "sites".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $name
 */
class Sites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'url'   => 'Url',
            'name'  => 'Name',
        ];
    }

    public function getPhoto()
    {
        return $this->hasOne(Files::class, ['related_id' => 'id'])->andWhere(['related_class' => self::class])
            ->andWhere(['main' => 1]);
    }

}
