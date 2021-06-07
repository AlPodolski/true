<?php


namespace common\components\helpers;


use common\components\service\notify\Notify;
use common\models\Event;
use frontend\modules\user\models\Posts;
use Yii;

class AddEventHelper
{
    public static function addStatus( $oldStatus, Posts $newParams)
    {

        $event = new Event();

        $event->status = Event::NOT_READ_EVENT;
        $event->post_id = $newParams->id;
        $event->user_id = $newParams->user_id;

        if ($oldStatus == Posts::POST_ON_MODARATION_STATUS and $newParams->status == Posts::RETURNED_FOR_REVISION){

            $event->type = Event::POST_RETURNED_FOR_REVISION;

            if ($event->save()) $notifyText = \str_replace(':name' ,
                $newParams->name ,
                Yii::$app->params['returned_for_revision_text']);

        }
        if ($oldStatus == Posts::POST_ON_MODARATION_STATUS and $newParams->status == Posts::POST_ON_PUPLICATION_STATUS){

            $event->type = Event::POST_ON_PUPLICATION_STATUS;

            if ($event->save()) $notifyText = \str_replace(':name' ,
                $newParams->name ,
                Yii::$app->params['anket_check_text']);

        }

        if (isset($notifyText) and $notifyText){

            Notify::send($notifyText, $newParams->user_id);

        }

    }
}