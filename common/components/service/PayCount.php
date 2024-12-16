<?php

namespace common\components\service;

use common\models\CashCount;
use frontend\components\events\BillPayEvent;
use yii\base\Component;

class PayCount extends Component
{
    public static function handle(BillPayEvent $event)
    {

        $date = date('d-m-Y', time());

        if ($count = CashCount::find()->where(['date' => $date])->one()){

            $count->count = $count->count + $event->sum;

            $count->save();

        }else{

            $count = new CashCount();

            $count->count = $event->sum;
            $count->date = $date;

            $count->save();

        }
    }
}