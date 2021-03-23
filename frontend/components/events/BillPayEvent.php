<?php


namespace frontend\components\service;

use yii\base\Event;

class BillPayEvent extends Event
{
    public $user_id;

    public $sum;

    public $type;

    public $balance;

}