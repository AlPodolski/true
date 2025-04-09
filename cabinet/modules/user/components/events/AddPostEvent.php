<?php

namespace cabinet\modules\user\components\events;

use cabinet\modules\user\models\Posts;
use yii\base\Event;

class AddPostEvent extends Event
{
    /* @var $post Posts */
    public $post;
}