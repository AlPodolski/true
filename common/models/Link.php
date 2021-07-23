<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string|null $url url на которой распологается ссылка
 * @property string|null $link url на которой ведет ссылка
 * @property string|null $text текст ссылки
 * @property string|null $city_id ид города, 0 для всех городов
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'link', 'text'], 'string', 'max' => 255],
            [['city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Урл на котором размещается ссылка',
            'link' => 'Ссылка',
            'text' => 'Текст ссылки',
            'city_id' => 'ид города',
        ];
    }
}
