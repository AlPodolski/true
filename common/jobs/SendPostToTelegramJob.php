<?php

namespace common\jobs;

use common\components\helpers\TelegramChanelHelper;
use common\models\SendPostToTelegram;
use frontend\modules\user\models\Posts;
use yii\queue\JobInterface;
use yii\base\BaseObject;

class SendPostToTelegramJob extends BaseObject implements JobInterface
{

    public $postId;

    public function execute($queue)
    {

        $post = Posts::find()->with('gallery', 'avatar', 'metro')
            ->where(['id' => $this->postId])
            ->limit(1)
            ->one();

        $media = TelegramChanelHelper::preparePostInfo($post);

        TelegramChanelHelper::sendPostToChanel($media);

        SendPostToTelegram::updateAll(['status' => 1], ['post_id' => $this->postId]);

    }

}