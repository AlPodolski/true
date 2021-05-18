<?php


namespace common\components\helpers;


use common\models\Event;
use frontend\modules\user\models\Posts;

class AddEventHelper
{
    public static function addStatus( $oldStatus, Posts $newParams)
    {
        if ($oldStatus == Posts::POST_ON_MODARATION_STATUS and $newParams->status == Posts::RETURNED_FOR_REVISION){

            $event = new Event();

            $event->status = Event::NOT_READ_EVENT;
            $event->type = Event::POST_RETURNED_FOR_REVISION;
            $event->post_id = $newParams->id;
            $event->user_id = $newParams->user_id;

            $event->save();

        }
    }
}