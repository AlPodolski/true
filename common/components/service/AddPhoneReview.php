<?php

namespace common\components\service;

use common\models\Phone;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\Review;
use yii\base\Component;

class AddPhoneReview extends Component
{
    public static function handle($event)
    {
        $comment = $event->sender;

        /* @var $comment Review */

        $post = Posts::find()->where(['id' => $comment->post_id])->one();

        if ($post and $phone = Phone::find()->where(['phone'])){



        }

        dd($comment);
    }
}