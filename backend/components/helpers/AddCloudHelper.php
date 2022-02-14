<?php

namespace backend\components\helpers;

use Yii;

class AddCloudHelper
{
    public static function add($city)
    {
        $content = array(
            'type' => "A",
            'name' => $city,
            'content' => Yii::$app->params['server_ip'],
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/".Yii::$app->params['cloud_zone']."/dns_records");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = [
            'X-Auth-Email: ' . Yii::$app->params['cloud_email'],
            'X-Auth-Key: ' . Yii::$app->params['cloud_api'],
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        $object = json_decode($server_output);

        $zapid = $object->result->id;


        curl_close($ch);

        // пытаемся поставить галочку на облаке
        $zoneindetif = "https://api.cloudflare.com/client/v4/zones/".Yii::$app->params['cloud_zone']."/dns_records/$zapid";


        $content = array(
            'type' => "A",
            'name' => $city,
            'content' => Yii::$app->params['server_ip'],
            'proxied' => true,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $zoneindetif);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'X-Auth-Email: ' . Yii::$app->params['cloud_email'],
            'X-Auth-Key: ' . Yii::$app->params['cloud_api'],
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_exec($ch);

    }
}