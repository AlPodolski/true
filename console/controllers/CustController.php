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
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\console\Controller;

class CustController extends Controller
{
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
        $postsNational = UserIntimHair::find()->all();

        foreach ($postsNational as $item) {

            if ($post = Posts::find()->where(['id' => $item->post_id])->one()) {

                $post->intim_hair_id = $item->color_id;

                $post->save();

            }

        }
    }

    public function actionIndex()
    {

        $oldIp = '185.197.162.110';
        $newIp = '185.197.160.22';
        $zone = '436e67f7d3f0e614b1626f0e0a7f5654';
        $token = 'df732c943d439bdb9f69a39bd36a64f689db1';

        $cloudUrl = 'https://api.cloudflare.com/client/v4/zones/' . $zone . '/dns_records?';

        $dataRequest = 'content=' . $oldIp . '&page=1&per_page=100';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $cloudUrl . $dataRequest);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = [
            'X-Auth-Email: ' . 'rino.kim@yandex.ru',
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
}