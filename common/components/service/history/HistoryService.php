<?php


namespace common\components\service\history;

use common\models\History;
use yii\base\Component;

class HistoryService extends Component
{
    public function addToHistory(\yii\base\Event $event)
    {
        $history = new History();

        $history->balance = $event->balance;
        $history->sum = $event->sum;
        $history->type = $event->type;
        $history->user_id = $event->type;
        $history->created_at = \time();

        $history->save();

    }
}