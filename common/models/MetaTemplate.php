<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "meta_template".
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $title
 * @property string|null $des
 * @property string|null $h1
 */
class MetaTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meta_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'des'], 'string'],
            [['url', 'h1'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'title' => 'Title',
            'des' => 'Des',
            'h1' => 'H1',
        ];
    }
}
