<?php


namespace frontend\components\service\pay;

use Yii;

class QiwiPayService
{
    public function pay()
    {
        $publicKey = Yii::$app->params['qiwi_public_key'];
        $params = [
            'publicKey' => $publicKey,
            'amount' => 200,
            'billId' => 'cc961e8d-d4d6-4f02-b737-2297e51fb48e',
            'email' => 'example@mail.org',
            'account' => '21'
        ];

        $billPayments = new \Qiwi\Api\BillPayments();

        $link = $billPayments->createPaymentForm($params);

        return $link;
    }
}