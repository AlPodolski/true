<?php


namespace console\controllers;

use common\models\City;
use common\models\Rayon;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserRayon;
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\console\Controller;

class CustController extends Controller
{
    public function actionPrice()
    {
        $posts = Posts::find()->where(['fake' => Posts::POST_FAKE])->all();

        foreach ($posts as $post){

            if ($post->price > 2000) $post->express_price = $post->price - 1000;
            $post->price_2_hour = $post->price * 2;
            $post->price_night = $post->price * 4;

            $post->save();

        }
    }

    public function actionIndex()
    {

        $cloudUrl = 'https://api.cloudflare.com/client/v4/zones//dns_records?';

        $dataRequest = 'content='.$oldIp.'&page=1&per_page=100';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $cloudUrl.$dataRequest);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = [
            'X-Auth-Email: ' . 'anketa-dosug@yandex.ru',
            'X-Auth-Key: ' . $token,
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        $object = json_decode($server_output);

        curl_close($ch);

        foreach ($object->result as $item){

            if (!isset($item->id)) continue;

            $zapid = $item->id;


            // пытаемся поставить галочку на облаке
            $zoneindetif = "https://api.cloudflare.com/client/v4/zones//dns_records/$zapid";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $zoneindetif);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'X-Auth-Email: ' . 'anketa-dosug@yandex.ru',
                'X-Auth-Key: ' . $token,
                'Content-Type: application/json',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec($ch);

        }

    }
}