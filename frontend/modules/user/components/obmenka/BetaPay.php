<?php

namespace frontend\modules\user\components\obmenka;

class BetaPay
{
    protected $api;

    public function __construct()
    {

        $publicKey = \Yii::$app->params['beta_public_key'];
        $secretKey = \Yii::$app->params['beta_secret_key'];

        $this->api = new BetaApi($publicKey, $secretKey);
    }

    public function getPayUrl($orderId, $sum, $city, $currency)
    {
        $data = $this->api->payment($sum, $currency, $orderId, $city);

        if ($data and isset($data['body']['urlPayment'])){

            return $data['body']['urlPayment'];

        }
    }
}