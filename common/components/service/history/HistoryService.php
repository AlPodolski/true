<?php


namespace common\components\service\history;

use common\models\History;
use frontend\components\events\BillPayEvent;
use yii\base\Component;

class HistoryService extends Component
{
    public function addToHistory(BillPayEvent $event)
    {
        $history = new History();

        $history->balance = $event->balance;
        $history->sum = $event->sum;
        $history->type = $event->type;
        $history->user_id = $event->user_id;
        if ($event->post_id) $history->post_id = $event->post_id;
        $history->created_at = \time();

        $history->save();

    }
}