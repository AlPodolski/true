<?php

namespace frontend\modules\user\models;

use common\components\service\AddPhoneReview;
use common\models\User;
use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int|null $post_id
 * @property string|null $text
 * @property string|null $name
 * @property int|null $photo_marc
 * @property int|null $clean
 * @property int|null $total_marc
 * @property int|null $author
 * @property int|null $created_at
 * @property int|null $is_happy
 * @property int|null $is_moderate
 * @property Posts $article
 */
class Review extends \yii\db\ActiveRecord
{

    const ON_MODARATE = 0;
    const MODARATE = 1;

    const COMMENT_MODERATE = 'moderate';

    public function __construct()
    {
        $this->on(self::COMMENT_MODERATE, [AddPhoneReview::class, 'handle']);

        parent::__construct();
    }

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
            [['post_id', 'photo_marc',  'total_marc', 'clean', 'author', 'is_happy', 'is_moderate'], 'integer'],
            [['text', 'name'], 'string'],
        ];
    }

    public function getServiceMarc()
    {
        return $this->hasMany(ServiceReviews::class, ['post_id' => 'post_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Автор',
            'post_id' => 'Пост',
            'text' => 'Текс',
            'photo_marc' => 'Оценка фото',
            'service_marc' => 'Обслуживание',
            'total_marc' => 'Общая оценка',
            'is_moderate' => 'Статус',
            'clean' => 'Чистота',
            'created_at' => 'Дата добавления',
        ];
    }

    public function getArticle()
    {
        return $this->hasOne(Posts::class, ['id' => 'post_id'])->with('avatar');
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author'])->with('avatar');
    }
    public function getPost()
    {
        return $this->hasOne(Posts::class, ['id' => 'author'])->with('service');
    }

}
