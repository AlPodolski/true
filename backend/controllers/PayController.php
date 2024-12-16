<?php

namespace backend\controllers;

use common\components\service\history\HistoryService;
use common\components\service\PayCount;
use common\models\History;
use common\models\ObmenkaOrder;
use common\models\User;
use frontend\components\events\BillPayEvent;
use yii\web\Controller;
use Yii;

class PayController extends Controller
{

    public function behaviors()
    {
        return [
            \backend\components\behaviors\isAdminAuth::class,
        ];
    }

    const OBMENKA_PAY = 'pay';

    public function init()
    {
        $this->on(self::OBMENKA_PAY, [HistoryService::class, 'addToHistory']);
        $this->on(self::OBMENKA_PAY, [PayCount::class, 'handle']);

        parent::init();
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionCheck()
    {
        $orderId = \Yii::$app->request->post('id');

        if ($order = ObmenkaOrder::findOne($orderId)
            and $order['status'] == ObmenkaOrder::WAIT
            and $user = User::findOne($order['user_id'])) {

            $transaction = Yii::$app->db->beginTransaction();

            $order->status = ObmenkaOrder::FINISH;

            $sum = $order['sum'];

            if ($sum >= Yii::$app->params['start_sum_for_bonus']) {

                $bonus = ($sum / 100) * Yii::$app->params['pay_bonus_percent'];
                $user->cash = $user->cash + (int)$bonus + $sum;

            } else {

                $user->cash = $user->cash + $sum;

            }

            if ($user->status == User::STATUS_INACTIVE) {

                $user->cash = $user->cash + 100;
                $user->status = User::STATUS_ACTIVE;

            }

            if ($user->save() and $order->save()) {

                $transaction->commit();

                $billPayEvent = new BillPayEvent();

                $billPayEvent->user_id = $user->id;
                $billPayEvent->sum = $sum;
                $billPayEvent->type = History::BALANCE_REPLENISHMENT;
                $billPayEvent->balance = $user->cash;

                $this->trigger(self::OBMENKA_PAY, $billPayEvent);

            }
        }
    }
}