<?php


namespace cabinet\components\helpers;


use common\models\Event;
use yii\helpers\ArrayHelper;

class EventHelper
{
    public static function setRead($events)
    {
        $eventsIds = ArrayHelper::getColumn($events, 'id');

        Event::updateAll(['status' => Event::READ_EVENT], ['in', 'id', $eventsIds]);
    }
}