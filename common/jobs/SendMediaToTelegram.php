<?php

namespace common\jobs;

use common\components\helpers\TelegramChanelHelper;
use yii\queue\JobInterface;
use yii\base\BaseObject;

class SendMediaToTelegram extends BaseObject implements JobInterface
{

    public $data;

    public function execute($queue)
    {
        sleep(60);

        TelegramChanelHelper::sendPostToChanel($this->data);
    }
}