<?php

namespace frontend\modules\user\components\obmenka;

use common\models\City;

class BetaApi
{
    const BASE_URL = 'https://merchant.betatransfer.io/api/';

    /**
     * @var string
     */
    private $public;

    /**
     * @var string
     */
    private $secret;


    public function __construct(string $public, string $secret)
    {
        $this->public = $public;
        $this->secret = $secret;
    }


    /**
     * Создание платежа
     * @param string $amount
     * @param string $currency
     * @param string $orderId
     * @param string $city
     * @param array $options
     * @return array
     */
    public function payment(
        string $amount,
        string $paymentSystem,
        string $orderId,
        string $city,
        array $options = []
    ): array {

        $siteUrl = $this->makeSiteUrl($city);

        $options['amount'] = $amount;
        $options['currency'] = 'RUB';
        $options['paymentSystem'] = $paymentSystem;
        $options['orderId'] = $orderId;
        $options['urlResult'] = $siteUrl.'/beta/pay/success';
        $options['urlSuccess'] = $siteUrl.'/cabinet';
        $options['fullCallback'] = 1;

        $options['sign'] = $this->generateSign($options);

        $queryData = [
            'token' => $this->public,
        ];

        return $this->request('/payment?' . http_build_query($queryData), $options);

    }

    private function makeSiteUrl($city){

        $cityInfo = City::find()->where(['url' => $city])->one();

        if ($cityInfo->actual_city) $result = 'https://'.$cityInfo->actual_city.'.'.$cityInfo->domain;
        else $result = 'https://'.$city.'.'.$cityInfo->domain;

        return $result;

    }


    /**
     * Инициализация платежа для h2h
     * @param string $amount
     * @param string $currency
     * @param string $orderId
     * @param string $paymentSystem
     * @param string $urlSuccess
     * @param string $urlFail
     * @param array $options
     * @return array
     */
    public function h2hInitialization(
        string $amount,
        string $currency,
        string $orderId,
        string $paymentSystem,
        string $urlSuccess,
        string $urlFail,
        array $options = []
    ): array {

        $options['fullCallback'] = 1;
        $options['amount'] = $amount;
        $options['currency'] = $currency;
        $options['orderId'] = $orderId;
        $options['paymentSystem'] = $paymentSystem;
        $options['urlSuccess'] = $urlSuccess;
        $options['urlFail'] = $urlFail;

        $options['sign'] = $this->generateSign($options);

        $queryData = [
            'token' => $this->public,
        ];

        return $this->request('/h2h/initialization?' . http_build_query($queryData), $options);
    }


    public function h2hCard(
        string $hash,
        string $card_number,
        string $expiry_month,
        string $expiry_year,
        string $cvv,
        array $options = []
    ): array {
        $options['hash'] = $hash;
        $options['card_number'] = $card_number;
        $options['expiry_month'] = $expiry_month;
        $options['expiry_year'] = $expiry_year;
        $options['cvv'] = $cvv;

        $options['sign'] = $this->generateSign($options);

        $queryData = [
            'token' => $this->public,
        ];

        return $this->request('/h2h/card?' . http_build_query($queryData), $options);
    }


    /**
     * Создание запроса на вывод
     * @param string $amount
     * @param string $currency
     * @param string $orderId
     * @param string $paymentSystem
     * @param array $options
     * @return array
     */
    public function withdrawalPayment(string $amount, string $currency, string $orderId, string $paymentSystem, array $options = []): array
    {

        $options['amount'] = $amount;
        $options['currency'] = $currency;
        $options['orderId'] = $orderId;
        $options['paymentSystem'] = $paymentSystem;

        $options['sign'] = $this->generateSign($options);

        $queryData = [
            'token' => $this->public,
        ];

        return $this->request('/withdrawal-payment?' . http_build_query($queryData), $options);
    }


    /**
     * Информация о балансе аккаунта и его статусе
     * @return array
     */
    public function accountInfo(): array
    {

        $queryData = [
            'token' => $this->public,
            'sign' => md5($this->public . $this->secret)
        ];

        return $this->request('/account-info?' . http_build_query($queryData));
    }

    /**
     * @param string|null $id
     * @param string|null $orderId
     * @return array
     * @throws Exception
     */
    public function info(string $id = null, string $orderId = null): array
    {

        $options = [];

        if ($id){
            $options['id'] = $id;
        }
        if ($orderId){
            $options['orderId'] = $orderId;
        }

        if (!$options){
            throw new Exception();
        }

        $options['sign'] = $this->generateSign($options);

        $queryData = [
            'token' => $this->public,
        ];

        return $this->request('/info?' . http_build_query($queryData), $options);
    }

    public function history(array $options = []): array
    {

        $options['sign'] = $this->generateSign($options);

        $queryData = [
            'token' => $this->public,
        ];

        return $this->request('/history?' . http_build_query($queryData), $options);
    }


    /**
     * @param array $options
     * @return string
     */
    private function generateSign(
        array $options
    ): string {
        return md5(implode("", $options) . $this->secret);
    }


    public function callbackSignIsValid($sign, $amount, $orderId): bool
    {
        return $sign == md5($amount . $orderId . $this->secret);
    }

    /**
     * @param string $action
     * @param array $data
     * @return array
     */
    private function request(
        string $action,
        array $data = []
    ): array {
        $ch = curl_init();

        $url = rtrim(self::BASE_URL, '/') . $action;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $curlError = curl_error($ch);

        $curlErrno = curl_errno($ch);

        curl_close($ch);

        if ($httpCode == 200) {
            $response = json_decode($response, true);
        }

        return [
            'code' => $httpCode,
            'error' => $curlError,
            'errno' => $curlErrno,
            'body' => $response,
        ];
    }
}