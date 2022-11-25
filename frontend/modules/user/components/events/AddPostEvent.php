<?php

namespace frontend\modules\user\components\events;

use frontend\modules\user\models\Posts;
use yii\base\Event;

class AddPostEvent extends Event
{
    /* @var $post Posts */
    public $post;
}