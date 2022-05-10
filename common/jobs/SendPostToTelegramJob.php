<?php

namespace common\jobs;

use common\components\helpers\TelegramChanelHelper;
use frontend\modules\user\models\Posts;
use yii\queue\JobInterface;
use yii\base\BaseObject;
use Yii;

class SendPostToTelegramJob extends BaseObject implements JobInterface
{

    public $postId;

    public function execute($queue)
    {
        sleep(60);

        $post = Posts::find()->with('gallery', 'avatar', 'metro')
            ->where(['id' => $this->postId])
            ->limit(1)
            ->one();

        TelegramChanelHelper::sendPostToChanel($post);
    }

}