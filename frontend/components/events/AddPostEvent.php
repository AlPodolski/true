<?php

namespace frontend\components\events;

use yii\base\Event;

class AddPostEvent extends Event
{
    public $post_id;
}