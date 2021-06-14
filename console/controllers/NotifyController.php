<?php


namespace console\controllers;

use common\components\service\notify\Notify;
use frontend\modules\chat\models\Message;
use yii\console\Controller;

class NotifyController extends Controller
{
    public function actionMessage()
    {

        $from_time = \time() - 3600;

        $to_time = \time() - 1800;

        $user_ids = Message::find()
            ->where(['status' => 0])
            ->andWhere([ '>', 'created_at' , $from_time])
            ->andWhere(['<', 'created_at' , $to_time])
            ->all();

        $usersSendNotify = array();

        foreach ($user_ids as $user_id){

            if (!\in_array($user_id['to'], $usersSendNotify)) {

                Notify::send('У вас новое сообщение на сайте sex-true ', $user_id['to']);

                $usersSendNotify[] = $user_id['to'];

            }

        }

    }
}