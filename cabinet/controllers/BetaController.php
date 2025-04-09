<?php

namespace cabinet\controllers;

use common\components\service\history\HistoryService;
use common\components\service\PayCount;
use common\models\History;
use common\models\ObmenkaOrder;
use common\models\User;
use cabinet\components\events\BillPayEvent;
use Yii;

class BetaController extends \yii\web\Controller
{

    const OBMENKA_PAY = 'pay';

    public function init()
    {
        $this->on(self::OBMENKA_PAY, [HistoryService::class, 'addToHistory']);
        $this->on(self::OBMENKA_PAY, [PayCount::class, 'handle']);

        parent::init();
    }

    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $orderId = \Yii::$app->request->post('orderId');
        $amount = \Yii::$app->request->post('amount');
        $status = \Yii::$app->request->post('status');

        $orderId = str_replace('-' . Yii::$app->params['obm-id-pref'], '', $orderId);

        $order = ObmenkaOrder::find()->where(['id' => $orderId])->andWhere(['status' => ObmenkaOrder::WAIT])->one();

        if ($order and ($status == 'success' or $status == 'partial_payment')) {

            $user = User::findOne($order['user_id']);

            if ($amount >= Yii::$app->params['start_sum_for_bonus']) {

                $bonus = ($amount / 100) * Yii::$app->params['pay_bonus_percent'];
                $user->cash = $user->cash + (int)$bonus + $amount;

            } else {

                $user->cash = $user->cash + $amount;

            }

            if ($user->status == User::STATUS_INACTIVE) {

                $user->cash = $user->cash + 100;
                $user->status = User::STATUS_ACTIVE;

            }

            $order->status = ObmenkaOrder::FINISH;

            if ($user->save() and $order->save()) {

                $billPayEvent = new BillPayEvent();

                $billPayEvent->user_id = $user->id;
                $billPayEvent->sum = $amount;
                $billPayEvent->type = History::BALANCE_REPLENISHMENT;
                $billPayEvent->balance = $user->cash;

                $this->trigger(self::OBMENKA_PAY, $billPayEvent);

            }

        }

    }

}
