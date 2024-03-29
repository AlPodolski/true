<?php


namespace frontend\modules\user\models;

use Yii;
use yii\base\Model;

class ReviewForm extends Model
{
    public $photo;
    public $clean;
    public $total;
    public $text;
    public $post_id;
    public $author_id;
    public $name;

    public function attributeLabels()
    {
        return [
            'photo' => 'Фото',
            'clean' => 'Чистота',
            'total' => 'Общая',
            'text' => 'Комментарий',
            'name' => 'Имя',
        ];
    }

    public function rules()
    {
        return [
            [['photo','clean','total', 'post_id'], 'integer'],
            [['text', 'name'] , 'string'],
            [['text'] , 'required'],
        ];
    }


    public function save()
    {
        $review = new Review();

        $review->post_id = $this->post_id;
        $review->name = $this->name;
        $review->text = $this->text;
        $review->photo_marc = $this->photo;
        $review->clean = $this->clean;
        $review->author = $this->author_id ?? null;
        $review->total_marc = $this->total;
        $review->created_at = \time();

        Yii::$app->cache->delete('review_'.$this->post_id);
        Yii::$app->cache->delete('review_count_'.$this->post_id);

        if ($review->save()) return $review;

        return false;

    }

}