<?php

namespace common\jobs;

use common\components\service\notify\Notify;
use yii\queue\JobInterface;
use yii\base\BaseObject;
use yii\queue\Queue;

class SendMail extends BaseObject implements JobInterface
{

    public $to;
    public $text;
    public $subject;

    public function execute($queue)
    {
        Notify::send($this->text, $this->to, $this->subject);
    }
}