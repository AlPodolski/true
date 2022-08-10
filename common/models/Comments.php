<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $class
 * @property int|null $related_id
 * @property string|null $text
 * @property int|null $created_at
 * @property int|null $author_id
 */
class Comments extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'related_id', 'created_at', 'author_id'], 'integer'],
            [['class'], 'string', 'max' => 120],
            [['text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'class' => 'Class',
            'related_id' => 'Related ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'author_id' => 'Author ID',
        ];
    }

    public function getAuthor(){

        return $this->hasOne(User::class, ['id' => 'author_id'])->with('avatar');

    }
}
