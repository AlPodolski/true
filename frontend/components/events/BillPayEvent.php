<?php


namespace frontend\components\events;

use yii\base\Event;

class BillPayEvent extends Event
{
    public $user_id;

    public $sum;

    public $type;

    public $balance;

    public $post_id;

}