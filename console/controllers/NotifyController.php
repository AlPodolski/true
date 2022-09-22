<?php


namespace console\controllers;

use common\components\service\notify\Notify;
use common\jobs\SendMail;
use common\models\Queue;
use frontend\modules\chat\models\Message;
use yii\console\Controller;
use Yii;

class NotifyController extends Controller
{
    public function actionMessage()
    {

        $from_time = \time() - 900;

        $to_time = \time() - 450;

        $user_ids = Message::find()
            ->where(['status' => 0])
            ->andWhere([ '>', 'created_at' , $from_time])
            ->andWhere(['<', 'created_at' , $to_time])
            ->all();

        $usersSendNotify = array();

        foreach ($user_ids as $user_id){

            if (!\in_array($user_id['to'], $usersSendNotify)) {

                $jobsCount = Queue::find()->where(['channel' => 'mail'])->count() + 1;

                Yii::$app->queueMail->delay($jobsCount * 10)->push(new SendMail([
                    'text' => 'У Вас новое сообщение',
                    'to' => $user_id['to'],
                    'subject' => 'Новое сообщение',
                ]));

                $usersSendNotify[] = $user_id['to'];

            }

        }

    }
}