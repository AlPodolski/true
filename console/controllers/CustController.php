<?php


namespace console\controllers;

use common\models\City;
use common\models\Rayon;
use common\models\Redirect;
use common\models\User;
use frontend\models\Files;
use frontend\models\UserMetro;
use frontend\models\Webmaster;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserRayon;
use frontend\modules\user\models\UserService;
use GuzzleHttp\Client;
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\console\Controller;
use GuzzleHttp\Exception\ClientException;

class CustController extends Controller
{

    private $client;
    private $access_token = 'y0_AgAAAABNB5owAAOcKgAAAADj-ZoaFQ2AImXXTSSKrpFrlxvoUYxeHN8';

    protected $user_id;

    public function __construct($id, $module, $config = [])
    {

        /*$this->client = new Client();

        $this->getUser();*/

        parent::__construct($id, $module, $config);
    }

    public function actionPrice()
    {
        $posts = Posts::find()
            ->where(['city_id' => '1'])
            ->andWhere(['fake' => Posts::POST_FAKE])
            ->limit(15000)
            ->all();

        foreach ($posts as $post) {

            if ($postPhoto = Files::findAll(['related_id' => $post['id'], 'related_class' => Posts::class])) {

                foreach ($postPhoto as $item) {

                    $file = Yii::getAlias('@app/web' . $item->file);

                    if (\is_file($file)) \unlink($file);

                    $item->delete();

                }

            }

            UserRayon::deleteAll(['post_id' => $post['id']]);
            UserMetro::deleteAll(['post_id' => $post['id']]);
            UserHairColor::deleteAll(['post_id' => $post['id']]);
            UserIntimHair::deleteAll(['post_id' => $post['id']]);
            UserNational::deleteAll(['post_id' => $post['id']]);
            UserPLace::deleteAll(['post_id' => $post['id']]);
            UserService::deleteAll(['post_id' => $post['id']]);

            $post->delete();

        }

    }

    public function actionCust()
    {
        $postsNational = UserRayon::find()->all();

        foreach ($postsNational as $item) {

            if ($post = Posts::find()->where(['id' => $item->post_id])->one()) {

                $post->rayon_id = $item->rayon_id;

                $post->save();

            }

        }
    }

    public function actionIndex()
    {

        $client = new Client();

        $this->getUser();

        $response = $client->request('GET', 'https://api.webmaster.yandex.net/v4/user/' . $this->user_id . '/hosts', [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->access_token,
            ]
        ]);

        $body = json_decode($response->getBody());

        foreach ($body->hosts as $item) {

            if (strpos($item->host_id, '.intim-boxx.com')) {

                $newHost = str_replace('.intim-boxx.com', '.proctitytki.com', $item->ascii_host_url);

                $id = $this->addHost($newHost);

                $this->startVarification($id);

                echo $newHost . PHP_EOL;

            }

        }

    }

    public function actionCloud()
    {

        $oldIp = '185.197.162.32';
        $newIp = '193.42.110.8';
        $zone = 'c368cf24050ec041b4d84802993c23f1';
        $token = 'f716ab864dd1d40dab325c43b64e185bfd517';

        $cloudUrl = 'https://api.cloudflare.com/client/v4/zones/' . $zone . '/dns_records?';

        $dataRequest = 'content=' . $oldIp . '&page=1&per_page=1000';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $cloudUrl . $dataRequest);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $headers = [
            'X-Auth-Email: ' . 'aprutic@gmail.com',
            'X-Auth-Key: ' . $token,
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        $object = json_decode($server_output);

        curl_close($ch);

        foreach ($object->result as $item) {

            if (!isset($item->id)) continue;

            $zapid = $item->id;

            $content = array(
                'type' => "A",
                'name' => $item->name,
                'content' => $newIp,
                'proxied' => true,
            );

            // пытаемся поставить галочку на облаке
            $zoneindetif = "https://api.cloudflare.com/client/v4/zones/" . $zone . "/dns_records/$zapid";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $zoneindetif);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec($ch);

        }
    }


    private
    function addWebmaster(City $city, $code)
    {

        $webmaster = new Webmaster();

        $webmaster->tag = $code;

        if (!$city->actual_city) $webmaster->city_id = $city->id;
        else $webmaster->city_name = $city->actual_city;

        $webmaster->save();

    }

    private
    function addHost($host)
    {

        $host = array('host_url' => $host);

        $response = $this->client->request('POST', 'https://api.webmaster.yandex.net/v4/user/' . $this->user_id . '/hosts', [
            'json' => $host,
            'headers' => [
                'Authorization' => 'OAuth ' . $this->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);

        $body = $response->getBody();

        $body = json_decode($body, true);

        return $body['host_id'];

    }

    private
    function getUser()
    {

        $response = $this->client->request('GET', 'https://api.webmaster.yandex.net/v4/user', [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->access_token
            ]
        ]);

        $body = $response->getBody();

        $body = json_decode($body, true);

        $this->user_id = $body['user_id'];

    }

    private
    function startVarification($host)
    {

        $response = $this->client->request('POST', 'https://api.webmaster.yandex.net/v4/user/' . $this->user_id . '/hosts/' . $host . '/verification?verification_type=HTML_FILE', [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->access_token
            ]
        ]);

        $body = $response->getBody();

        $body = json_decode($body, true);

        return $body['verification_uin'];

    }

    private
    function getHost(City $city)
    {

        if ($city->actual_city) $host = 'https:' . $city->actual_city . '.' . $city->domain . ':443';
        else $host = 'https:' . $city->url . '.' . $city->domain . ':443';

        return $host;

    }

}