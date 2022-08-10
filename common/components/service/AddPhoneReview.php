<?php

namespace common\components\service;

use common\models\Comments;
use common\models\Phone;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\Review;
use yii\base\Component;

class AddPhoneReview extends Component
{
    public static function handle($event)
    {
        $review = $event->sender;

        /* @var $review Review */

        $post = Posts::find()->where(['id' => $review->post_id])->one();

        if ($post){

            if (!$phone = Phone::find()->where(['like', 'phone', $post->phone])->one()){
                $phone = new Phone();
                $phone->phone = $post->phone;
                $phone->save();
            }

            $comment = new Comments();

            $comment->class = Phone::class;
            $comment->related_id = $phone->id;
            $comment->text = $review->text;

            $comment->save();

        }

    }
}