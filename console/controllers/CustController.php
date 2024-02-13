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
    private $access_token = 'y0_AgAAAAA1RTqTAAOcKgAAAADuqTDbsC3FerCmQgGkW-uOepsxIMfhnSE';

    protected $user_id;

    public function __construct($id, $module, $config = [])
    {

        $this->client = new Client();

        $this->getUser();

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

        $response = $client->request('GET', 'https://api.webmaster.yandex.net/v4/user/'.$this->user_id.'/hosts', [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->access_token,
            ]
        ]);

        $body = json_decode($response->getBody());

        foreach ($body->hosts as $item){

            if (strpos($item->host_id,'.intim-boxx.com')){

                $newHost = str_replace('.intim-boxx.com', '.proctitytki.com', $item->ascii_host_url);

                $id = $this->addHost($newHost);

                $this->startVarification($id);

                echo $newHost.PHP_EOL;

            }

        }

    }

    private function addWebmaster(City $city, $code){

        $webmaster = new Webmaster();

        $webmaster->tag = $code;

        if (!$city->actual_city) $webmaster->city_id = $city->id;
        else $webmaster->city_name = $city->actual_city;

        $webmaster->save();

    }

    private function addHost($host){

        $host = array('host_url' => $host);

        $response = $this->client->request('POST', 'https://api.webmaster.yandex.net/v4/user/'.$this->user_id.'/hosts', [
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

    private function getUser(){

        $response = $this->client->request('GET', 'https://api.webmaster.yandex.net/v4/user', [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->access_token
            ]
        ]);

        $body = $response->getBody();

        $body = json_decode($body, true);

        $this->user_id = $body['user_id'];

    }

    private function startVarification($host){

        $response = $this->client->request('POST', 'https://api.webmaster.yandex.net/v4/user/'.$this->user_id.'/hosts/'.$host.'/verification?verification_type=HTML_FILE', [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->access_token
            ]
        ]);

        $body = $response->getBody();

        $body = json_decode($body, true);

        return $body['verification_uin'];

    }

    private function getHost(City $city){

        if ($city->actual_city) $host = 'https:'.$city->actual_city.'.'.$city->domain.':443';
        else $host = 'https:'.$city->url.'.'.$city->domain.':443';

        return $host;

    }

}