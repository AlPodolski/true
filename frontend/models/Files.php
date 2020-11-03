<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int|null $related_id связанный ид
 * @property string|null $related_class связанный класс
 * @property string|null $file путь к файлу
 * @property int|null $main является ли изображение главным 0 нет 1 да
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['related_id', 'main'], 'integer'],
            [['related_class', 'file'], 'string', 'max' => 122],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'related_id' => 'Related ID',
            'related_class' => 'Related Class',
            'file' => 'File',
            'main' => 'Main',
        ];
    }
}
