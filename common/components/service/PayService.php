<?php

namespace common\components\service;

use common\components\service\history\HistoryService;
use common\models\History;
use common\models\User;
use frontend\components\events\BillPayEvent;
use frontend\modules\user\models\Posts;
use Yii;
use yii\base\Component;

class PayService extends Component
{

    const EVENT_BILL_PAY = 'bill_pay';

    public function init()
    {

        $this->on(self::EVENT_BILL_PAY, [HistoryService::class, 'addToHistory']);

        parent::init();

    }

    public function pay($sum, $user_id, $reason, $post_id = false)
    {
        if ($user = User::findOne($user_id) and $user->cash >= $sum){

            $transaction = Yii::$app->db->beginTransaction();

            $user->cash = $user->cash - $sum;

            if ($user->save()){

                $transaction->commit();

                $this->event($user->id, $sum , $reason, $user->cash, $post_id);

                return true;

            }

        }

        return false;

    }

    private function event($user_id, $sum, $reason, $balance, $post_id){

        $billPayEvent = new BillPayEvent();

        $billPayEvent->user_id = $user_id;
        $billPayEvent->sum = $sum;
        $billPayEvent->type = $reason;
        $billPayEvent->balance = $balance;
        $billPayEvent->post_id = $post_id;

        $this->trigger(self::EVENT_BILL_PAY, $billPayEvent);

    }

}