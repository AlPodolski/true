<?php


namespace frontend\modules\user\models;

use yii\base\Model;

class ReviewForm extends Model
{
    public $photo;
    public $clean;
    public $total;
    public $text;
    public $post_id;
    public $author_id;

    public function attributeLabels()
    {
        return [
            'photo' => 'Фото',
            'clean' => 'Чистота',
            'total' => 'Общая',
            'text' => 'Комментарий',
        ];
    }

    public function rules()
    {
        return [
            [['photo','clean','total', 'post_id'], 'integer'],
            [['text'] , 'string'],
        ];
    }


    public function save()
    {
        $review = new Review();

        $review->post_id = $this->post_id;
        $review->text = $this->text;
        $review->photo_marc = $this->photo;
        $review->clean = $this->clean;
        $review->author = $this->author_id;
        $review->total_marc = $this->total;
        $review->created_at = \time();

        if ($review->save()) return $review;

        return false;

    }

}