<?php

namespace frontend\modules\user\components\service;

use common\models\PhoneAdvertViewStat;
use frontend\modules\user\components\events\AddPostEvent;
use yii\base\Component;

class AddPostService extends Component
{
    public static function add(AddPostEvent $addPostEvent)
    {
        $phoneAdvertViewStat = new PhoneAdvertViewStat();

        $phoneAdvertViewStat->post_id = $addPostEvent->post->id;

        $phoneAdvertViewStat->save();
    }
}