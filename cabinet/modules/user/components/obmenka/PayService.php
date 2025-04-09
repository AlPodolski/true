<?php

namespace cabinet\modules\user\components\obmenka;

use common\models\ObmenkaOrder;

class PayService
{
    public $payClass;

    public function __construct($paySystem)
    {
        switch ($paySystem) {
            case ObmenkaOrder::OBMENKA_PAY_SYSTEM:
                $this->payClass = new Obmenka();
                break;
            case ObmenkaOrder::BETA_PAY_SYSTEM:
                $this->payClass = new BetaPay();
                break;
        }
    }

    public function getPayUrl($orderId, $sum, $city, $currency)
    {
        return $this->payClass->getPayUrl($orderId, $sum, $city, $currency);
    }

}