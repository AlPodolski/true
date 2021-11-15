<?php

namespace console\controllers;

use common\models\AdvertCategory;
use common\models\Link;
use dastanaron\translit\Translit;
use common\models\City;
use common\models\HairColor;
use common\models\National;
use common\models\Osobenosti;
use common\models\Place;
use common\models\Rayon;
use common\models\Service;
use common\models\User;
use frontend\models\Files;
use frontend\models\Meta;
use frontend\models\Metro;
use frontend\models\UserMetro;
use frontend\models\Webmaster;
use frontend\modules\advert\models\Advert;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\PostSites;
use frontend\modules\user\models\Review;
use frontend\modules\user\models\ServiceDesc;
use frontend\modules\user\models\ServiceReviews;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserOsobenosti;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserRayon;
use frontend\modules\user\models\UserService;
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class ImportController extends Controller
{

    public $siteId;
    public $path;
    public $update;

    public function actionIndex()
    {
        $stream = \fopen(Yii::getAlias('@app/files/import_region_2021_11_12.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $translit = new Translit();
        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $placeList = Place::find()->asArray()->all();

        $serviceList = Service::find()->asArray()->all();

        $this->siteId = 8;
        $this->update = 17;
        $this->path = '/uploads/a17/';

        foreach ($records as $record) {

            $posts[] = $record;

        }

        $stmt = (new Statement());

        $records = $stmt->process($csv);

        foreach ($records as $record) {

            $city = City::find()->where(['city' => $record['city']])->one();

            $post = new Posts();

            $post->city_id = $city['id'];
            $post->pol_id = 1;
            $post->created_at = \time() - ((3600 * 24) * \rand(0, 365));
            $post->name = $record['name'];
            $post->updated_at = $this->update;
            $post->phone = preg_replace('/[^0-9]/', '',  $record['phone']);
            $post->about = $record['anket-about'];
            $post->check_photo_status = 0;
            $post->status = 1;
            $post->price = (int)$record['price'] ?? 1600;
            $post->age = $record['age'];
            $post->rost = $record['rost'];

            if ($post->price > 1000 and $post->price < 2000) $post->price = $post->price - 500;
            elseif ($post->price >= 2000 and $post->price < 4000) $post->price = $post->price - 1000;
            elseif ($post->price >= 4000 and $post->price < 6000) $post->price = $post->price - 1500;
            elseif ($post->price >= 6000 and $post->price < 8000) $post->price = $post->price - 2000;
            elseif ($post->price > 8000) $post->price = $post->price - 3000;

            if (isset($record['video']) and $record['video']) {

                $videoArray = \explode(',' , $record['video']);

                $post->video = $this->path . $videoArray[0];

            }

            if ($record['grud']) $post->breast = $record['grud'];

            if ($record['weight']) $post->ves = $record['weight'];

            $post->category = Posts::INDI_CATEGORY;

            if (isset($record['cheked']) and $record['cheked'] == 1) $post->check_photo_status = 1;

            if ($post->save()) {

                $postSite = new PostSites();

                $postSite->post_id = $post->id;
                $postSite->site_id = $this->siteId;
                $postSite->price = $post->price;
                $postSite->created_at = $post->created_at;
                $postSite->name_on_site = $post->name;
                $postSite->age = $post->age;

                $postSite->save();

                if (isset($record['rayon']) and $record['rayon']) {

                    $rayonId = ArrayHelper::getValue(Rayon::find()
                        ->where(['value' => $record['rayon']])
                        ->andWhere(['city_id' => $city['id']])
                        ->asArray()->one(), 'id');

                    if ($rayonId) {

                        $userRayon = new UserRayon();
                        $userRayon->post_id = $post->id;
                        $userRayon->rayon_id = $rayonId;
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                if (isset($record['metro']) and $metro = $record['metro']) {

                    if ($metro) {

                        $id = ArrayHelper::getValue(Metro::find()->where(['value' => $metro])->asArray()->one(), 'id');

                        if ($id) {

                            $userRayon = new UserMetro();
                            $userRayon->post_id = $post->id;
                            $userRayon->metro_id = $id;
                            $userRayon->city_id = $city['id'];
                            $userRayon->save();

                        }

                    }

                }

                if (isset($record['hair']) and $record['hair']) {

                    $id = ArrayHelper::getValue(HairColor::find()->where(['value' => $record['hair']])->asArray()->one(), 'id');

                    if ($id) {

                        $userRayon = new UserHairColor();
                        $userRayon->post_id = $post->id;
                        $userRayon->hair_color_id = $id;
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                if (isset($record['ethnik']) and $record['ethnik']) {

                    $id = ArrayHelper::getValue(National::find()->where(['value' => $record['ethnik']])->asArray()->one(), 'id');

                    if ($id) {

                        $userRayon = new UserNational();
                        $userRayon->post_id = $post->id;
                        $userRayon->national_id = $id;
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                foreach ($placeList as $placeItem){

                    if (\rand(0 , 2) == 1){

                        $userRayon = new UserPlace();
                        $userRayon->post_id = $post->id;
                        $userRayon->place_id = $placeItem['id'];
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                /* if (isset($record['mesto']) and $record['mesto']) {

                     $placeAr = \explode(',', $record['mesto']);

                     foreach ($placeAr as $item) {

                         $id = ArrayHelper::getValue(Place::find()->where(['value' => $item])->asArray()->one(), 'id');

                         if ($id) {

                             $userRayon = new UserPlace();
                             $userRayon->post_id = $post->id;
                             $userRayon->place_id = $id;
                             $userRayon->city_id = $city['id'];
                             $userRayon->save();

                         }

                     }

                 }*/

                if (isset($record['osob']) and $record['osob']) {

                    $Ar = \explode(',', $record['osob']);

                    foreach ($Ar as $item) {

                        $id = ArrayHelper::getValue(Osobenosti::find()->where(['value' => $item])->asArray()->one(), 'id');

                        if ($id) {

                            $userRayon = new UserOsobenosti();
                            $userRayon->post_id = $post->id;
                            $userRayon->param_id = $id;
                            $userRayon->city_id = $city['id'];
                            $userRayon->save();

                        }

                    }

                }

                foreach ($serviceList as $serviceItem) {

                    if (\rand(0, 3) == 3) {

                        $userRayon = new UserService();
                        $userRayon->post_id = $post->id;
                        $userRayon->service_id = $serviceItem['id'];
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                if (isset($record['mini']) and $record['mini']) {

                    $userPhoto = new Files();

                    $userPhoto->related_id = $post->id;
                    $userPhoto->file = $this->path . $record['mini'];
                    $userPhoto->main = 1;
                    $userPhoto->type = 0;
                    $userPhoto->related_class = Posts::class;

                    $userPhoto->save();

                }

                if (isset($record['gallery']) and $record['gallery']) {

                    $gall = \explode(',', $record['gallery']);

                    if ($gall) {

                        foreach ($gall as $gallitem) {

                            if ($gallitem) {

                                $userPhoto = new Files();

                                $userPhoto->related_id = $post->id;
                                $userPhoto->file = $this->path . $gallitem;
                                $userPhoto->main = 0;
                                $userPhoto->type = 0;
                                $userPhoto->related_class = Posts::class;

                                $userPhoto->save();

                            }

                        }

                    }

                }

            }

        }

    }

    public function actionAdvert()
    {
        $stream = \fopen(Yii::getAlias('@app/files/advert_10_09_2021.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        foreach ($records as $record) {

            $avert = new Advert();

            $avert->title = \strstr($record['text'], '<br>', true);
            $avert->text = \str_replace('<br>', '. ', $record['text']);
            $avert->type = Advert::PUBLIC_TYPE;
            $avert->status = Advert::STATUS_CHECK;

            $avert->save();

        }
    }

    public function actionLink()
    {
        $linkItems = $this->getCsvItems(Yii::getAlias('@app/files/fast_links_23_07_2021.csv'));

        $url = \array_unique(ArrayHelper::getColumn($linkItems, 'page'));

        foreach ($url as $item) {

            $i = 0;

            \shuffle($linkItems);

            foreach ($linkItems as $linkItem) {

                if ($i > 2) break;

                if ($item != $linkItem['page']) {

                    $link = new Link();

                    $link->city_id = 1;

                    $link->url = $item;

                    $link->link = $linkItem['page'];

                    $link->text = $linkItem['key'];

                    $link->save();

                    $i++;

                }

            }

        }

    }

    private function getCsvItems($fileName)
    {

        $stream = \fopen($fileName, 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $result = array();

        foreach ($records as $record) {

            $result[] = $record;

        }

        return $result;

    }

    public function actionAddCheck()
    {
        $posts = Posts::find()->all();

        foreach ($posts as $post) {

            if (\rand(0, 3) == 3) {

                $post->check_photo_status = 1;

                $post->save();

            }

        }
    }

    public function actionAddReview()
    {
        $stream = \fopen(Yii::getAlias('@app/files/review.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        foreach ($records as $record) {

            $post = Posts::find()->where(['name' => $record['name']])->with('service')->asArray()->andWhere(['like', 'phone', $record['price']])->one();

            $data = \explode('#@', $record['age']);

            foreach ($data as $item) {

                $reviewData = \explode('$@', $item);

                if (isset($reviewData[1]) and $reviewData[1] and (int)$reviewData[0] > 0 and $post) {

                    $mark = 2 * ((int)$reviewData[0]);

                    if (!$user = User::find()->where(['username' => $reviewData[1]])->asArray()->one()) {

                        $user = new User();

                        $user->username = $reviewData[1];
                        $user->password_hash = Yii::$app->security->generateRandomString(60);
                        $user->auth_key = Yii::$app->security->generateRandomString();
                        $user->email = $post['id'] . 'admin@mail.com';
                        $user->status = 10;
                        $user->created_at = $time = \time();
                        $user->updated_at = $time;
                        $user->verification_token = Yii::$app->security->generateRandomString(43);

                        $user->save();

                    }

                    $review = new Review();

                    $review->post_id = $post['id'];
                    $review->text = $reviewData[2];
                    $review->photo_marc = ($mark - \rand(-2, 0)) ?? $mark;
                    $review->clean = ($mark - \rand(-2, 0)) ?? $mark;;
                    $review->author = $user['id'];
                    $review->total_marc = $mark;
                    $review->is_happy = \rand(0, 1);
                    $review->created_at = $post['created_at'] + (\rand(0, 3600 * 24 * 14));

                    $review->save();

                    if ($post['service']) {

                        foreach ($post['service'] as $item2) {

                            $serviceReview = new ServiceReviews();

                            $serviceReview->post_id = $post['id'];
                            $serviceReview->service_id = $item2['id'];
                            $serviceReview->marc = \rand(1, 10);

                            $serviceReview->save();

                        }

                    }


                }

            }

        }

    }

    public function actionAddToSites()
    {
        $posts = Posts::find()->where(['updated_at' => 1])->asArray()->all();

        foreach ($posts as $post) {

            $postSite = new PostSites();

            $postSite->post_id = $post['id'];
            $postSite->site_id = 4;
            $postSite->price = $post['price'];
            $postSite->created_at = $post['created_at'];
            $postSite->name_on_site = $post['name'];
            $postSite->age = $post['age'];

            $postSite->save();

        }
    }

    public function actionGal()
    {
        $posts = Posts::find()->where(['updated_at' => 1])->asArray()->all();

        foreach ($posts as $post) {

            if ($files = Files::find()->where(['related_id' => $post['id'], 'related_class' => Posts::class])->all()) {

                foreach ($files as $file) {

                    $file->file = \str_replace('aa2', 'aa3', $file->file);

                    $file->save();

                }

            }

        }
    }

    public function actionVideo()
    {
        $posts = Posts::find()->where(['updated_at' => 1])->all();

        foreach ($posts as $post) {

            if ($post['video']) {

                $post->video = \str_replace('aa2', 'aa3', $post->video);

                $post->save();

            }

        }
    }

    public function actionAddServiceMarc()
    {
        $reviews = Review::find()->with('post')->asArray()->all();

        foreach ($reviews as $review) {

            if ($review['post']['service']) {

                foreach ($review['post']['service'] as $item) {

                    $serviceReview = new ServiceReviews();

                    $serviceReview->post_id = $review['post']['id'];
                    $serviceReview->service_id = $item['id'];
                    $serviceReview->marc = \rand(1, 10);
                    $serviceReview->save();

                }

            }


        }

    }

    public function actionDrop()
    {
        $posts = Posts::find()->where(['updated_at' => 2])->all();

        foreach ($posts as $post) {

            UserMetro::deleteAll(['post_id' => $post->id]);
            UserRayon::deleteAll(['post_id' => $post->id]);
            UserHairColor::deleteAll(['post_id' => $post->id]);
            UserIntimHair::deleteAll(['post_id' => $post->id]);
            UserNational::deleteAll(['post_id' => $post->id]);
            UserOsobenosti::deleteAll(['post_id' => $post->id]);
            UserPlace::deleteAll(['post_id' => $post->id]);
            UserService::deleteAll(['post_id' => $post->id]);
            Files::deleteAll(['related_id' => $post->id, 'related_class' => Posts::class]);

            $post->delete();

        }
    }

    public function actionDns()
    {

        $citys = include 'dns-city.php';

        $host = 'sex-true.com';
        $ip = '193.42.108.121';

        foreach ($citys as $city) {

            $content = array(
                'type' => "A",
                'name' => $city,
                'content' => $ip,

            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/375e7fbf4f926ab5db1431f990329b80/dns_records");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'X-Auth-Email: ' . Yii::$app->params['cloud_email'],
                'X-Auth-Key: ' . Yii::$app->params['cloud_api'],
                'Content-Type: application/json',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec($ch);

            $object = json_decode($server_output);

            if (!isset($object->result->id)) continue;

            $zapid = $object->result->id;


            curl_close($ch);

            // пытаемся поставить галочку на облаке
            $zoneindetif = "https://api.cloudflare.com/client/v4/zones/375e7fbf4f926ab5db1431f990329b80/dns_records/$zapid";


            $content = array(
                'type' => "A",
                'name' => $city,
                'content' => $ip,
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

            $server_output = curl_exec($ch);

            echo $city . PHP_EOL;

        }

    }

    public function actionWebmaster()
    {
        $access_token = 'AgAAAABNB5owAAOcKnTtNSvAHEBslBQhuKfyGD8';
        $host = 'sex-true.com';

        $citys = City::find()->asArray()->all();

        foreach ($citys as $city) {

            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: en\r\n" .
                        "Cookie: foo=bar\r\n" .
                        'Authorization: OAuth ' . $access_token,
                )
            );

            $context = stream_context_create($opts);

            $user_id = file_get_contents("https://api.webmaster.yandex.net/v3/user/", false, $context);
            $user_id = json_decode($user_id);
            $user_id = $user_id->user_id;


            $content = '
                
                <Data>
                    <host_url>https://' . $city['url'] . '.' . $host . '</host_url>
                </Data>
                
                ';


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.webmaster.yandex.net/v4/user/{$user_id}/hosts/");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'Content-type: application/xml',
                'Authorization: OAuth ' . $access_token
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec($ch);

            curl_close($ch);

            $result = json_decode($server_output);


            $content = '';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.webmaster.yandex.net/v3/user/{$user_id}/hosts/" . urlencode($result->host_id) . "/verification/?verification_type=META_TAG");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'Content-type: application/xml',
                'Authorization: OAuth ' . $access_token
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec($ch);

            curl_close($ch);

            $server_output = json_decode($server_output);

            $meta2 = $server_output->verification_uin;

            $meta_model = new Webmaster();

            $meta_model->city_id = $city['id'];
            $meta_model->tag = $meta2;

            $meta_model->save();

        }
    }

    public function actionAddService()
    {
        $newService = array('Cекс по телефону', 'Виртуальный секс', 'Игрушки', 'Клизма', 'Легкое подчинение',
            'Лесби откровенное', 'Порка', 'Профессиональный массаж', 'Расслабляющий массаж', 'Секс групповой', 'Секс лесбийский',
            'Стриптиз профи', 'Трамплинг', 'Услуги семейной паре', 'Фетиш', 'Фингеринг', 'Фото/видео съемка',
            'Целуюсь');

        $posts = Posts::find()->asArray()->all();

        foreach ($newService as $item) {

            $translit = new Translit();

            if ($service = Service::find()->where(['value' => $item])->asArray()->one()) {

                foreach ($posts as $post) {

                    if (\rand(0, 2) == 1) {

                        $userService = new UserService();

                        $userService->service_id = $service['id'];
                        $userService->post_id = $post['id'];
                        $userService->city_id = $post['city_id'];

                        $userService->save();

                    }

                }

            }

        }

    }

    public function actionAddServiceComments()
    {
        $stream = \fopen(Yii::getAlias('@app/files/comments_for_service.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $translit = new Translit();
        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $values = array();

        foreach ($records as $record) {

            $values[] = $record;

        }
        $arr = array();
        foreach ($values as $value) {

            foreach ($values as $item) {

                if ($value['key'] == $item['key']) {

                    if (isset($arr[$item['key']]) and \is_array($arr[$item['key']])) {

                        if (!\in_array($value['value'], $arr[$item['key']])) $arr[$item['key']][] = $value['value'];

                    } else $arr[$item['key']][] = $value['value'];


                }

            }

        }

        foreach ($arr as $key => $value) {

            if ($service = Service::find()->where(['value' => $key])->with('posts')->asArray()->one()) {

                foreach ($service['posts'] as $item) {

                    if (\rand(0, 1) == 1) {

                        $serviceDesc = new ServiceDesc();
                        $serviceDesc->post_id = $item['post_id'];
                        $serviceDesc->service_id = $item['service_id'];

                        $serviceDesc->text = $value[\array_rand($value)];

                        $serviceDesc->save();

                    }

                }

            }

        }

    }

    public function actionAddRandomReview()
    {
        $posts = Posts::find()->asArray()->all();

        foreach ($posts as $post) {

            if (!Review::find()->where(['post_id' => $post['id']])->count()) {

                $review = new Review();

                $review->post_id = $post['id'];
                $review->photo_marc = \rand(4, 10);
                $review->total_marc = \rand(5, 10);
                $review->clean = \rand(2, 10);
                $review->is_happy = \rand(0, 1);

                $review->save();

                $service = UserService::find()->where(['post_id' => $post['id']])->asArray()->all();

                foreach ($service as $serviceItem) {

                    $servRev = new ServiceReviews();

                    $servRev->post_id = $post['id'];
                    $servRev->service_id = $serviceItem['service_id'];
                    $servRev->marc = \rand(3, 10);

                    $servRev->save();

                }


            }

        }
    }

}