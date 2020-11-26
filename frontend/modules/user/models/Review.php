<?php

namespace frontend\modules\user\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int|null $post_id
 * @property string|null $text
 * @property int|null $photo_marc
 * @property int|null $clean
 * @property int|null $total_marc
 * @property int|null $author
 * @property int|null $created_at
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'photo_marc',  'total_marc', 'clean', 'author'], 'integer'],
            [['text'], 'string'],
        ];
    }

    public function getServiceMarc()
    {
        return $this->hasMany(ServiceReviews::class, ['post_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'post_id' => 'Post ID',
            'text' => 'Text',
            'photo_marc' => 'Photo Marc',
            'service_marc' => 'Service Marc',
            'total_marc' => 'Total Marc',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author'])->with('avatar');
    }

}
