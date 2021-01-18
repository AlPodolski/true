<?php

namespace console\controllers;

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
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\PostSites;
use frontend\modules\user\models\Review;
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
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class ImportController extends Controller
{

    public $siteId;
    public $path;
    public $update;

    public function actionIndex()
    {
        $stream = \fopen(Yii::getAlias('@app/files/intim_city_15_01_2021.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $translit = new Translit();
        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $placeList = Place::find()->asArray()->all();
        $serviceList = Service::find()->asArray()->all();

        $this->siteId = 4;
        $this->update = 6;
        $this->path = '/uploads/aa6';

        foreach ($records as $record) {

            $city = City::find()->where(['city' => $record['rayon']])->asArray()->one();

            if ($record['phone'] and isset($city['id'])) {

                if ($post = Posts::find()->where(['like', 'phone', $record['phone']])->andWhere(['name' => $record['name']])->one()) {

                    $postSite = new PostSites();

                    $postSite->post_id = $post->id;
                    $postSite->site_id = $this->siteId;
                    $postSite->price = $post->price;
                    $postSite->created_at = $post->created_at;
                    $postSite->name_on_site = $record['name'];
                    $postSite->age = $record['age'];

                    if (isset($record['video']) and $record['video']) $post->video = \str_replace('files', $this->path, $record['video']);

                    $postSite->save();

                    $post->save();

                }
                elseif ($post = Posts::find()->where(['like', 'phone', $record['phone']])
                    ->andWhere(['<>', 'name', $record['name']])
                    ->one()){

                    $post = new Posts();

                    $post->city_id = $city['id'];
                    $post->created_at = \time() - ((3600 * 24) * \rand(0, 365));
                    $post->name = $record['name'];
                    $post->updated_at = $this->update;
                    $post->phone = $record['phone'];
                    $post->about = $record['anket-about'];
                    $post->check_photo_status = 0;
                    $post->price = (int)$record['price'];
                    $post->age = $record['age'];
                    $post->rost = $record['rost'];
                    $post->breast = $record['grud'];
                    $post->ves = $record['weight'];
                    $post->category = Posts::SALON_CATEGORY;

                    if (isset($record['video']) and $record['video']) $post->video = \str_replace('files', $this->path, $record['video']);

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

                            }else{

                                $rayonId = new Rayon();

                                $rayonId->value = $record['rayon'];
                                $rayonId->city_id = $city['id'];
                                $rayonId->url = \trim($translit->translit($record['rayon'], true, 'ru-en'));

                                $rayonId->save();

                                $userRayon = new UserRayon();
                                $userRayon->post_id = $post->id;
                                $userRayon->rayon_id = $rayonId->id;
                                $userRayon->city_id = $city['id'];
                                $userRayon->save();

                            }

                        }

                        if (isset($record['metro']) and $record['metro']) {

                            $metro = \explode(',', $record['metro']);

                            if ($metro) {

                                foreach ($metro as $metroItem){

                                    $id = ArrayHelper::getValue(Metro::find()->where(['value' => $metroItem])->asArray()->one(), 'id');

                                    if ($id) {

                                        $userRayon = new UserMetro();
                                        $userRayon->post_id = $post->id;
                                        $userRayon->metro_id = $id;
                                        $userRayon->city_id = $city['id'];
                                        $userRayon->save();

                                    }else{

                                        $metro = new Metro();

                                        $metro->value = $metroItem;
                                        $metro->city_id = $city['id'];
                                        $metro->url = \trim($translit->translit($metroItem, true, 'ru-en'));

                                        $metro->save();

                                        $userRayon = new UserMetro();
                                        $userRayon->post_id = $post->id;
                                        $userRayon->metro_id = $id;
                                        $userRayon->city_id = $city['id'];
                                        $userRayon->save();

                                    }

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

                        if (isset($record['etik']) and $record['etik']) {

                            $id = ArrayHelper::getValue(National::find()->where(['value' => $record['etik']])->asArray()->one(), 'id');

                            if ($id) {

                                $userRayon = new UserNational();
                                $userRayon->post_id = $post->id;
                                $userRayon->national_id = $id;
                                $userRayon->city_id = $city['id'];
                                $userRayon->save();

                            }

                        }

                        if (isset($record['mesto']) and $record['mesto']) {

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

                        }
                        else{

                            foreach ($placeList as $placeItem){

                                if (\rand(0,2) == 2){

                                    $userRayon = new UserPlace();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->place_id = $placeItem['id'];
                                    $userRayon->city_id = $city['id'];
                                    $userRayon->save();

                                }

                            }

                        }

                        if (isset($record['mass']) and $record['mass']) {

                            $Ar = \explode(',', $record['mass']);

                            foreach ($Ar as $item) {

                                $id = ArrayHelper::getValue(Service::find()->where(['value' => $item])->asArray()->one(), 'id');

                                if ($id) {

                                    $userRayon = new UserService();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->service_id = $id;
                                    $userRayon->city_id = $city['id'];
                                    $userRayon->save();

                                }

                            }

                        }

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

                        if (isset($record['serv']) and $record['serv']) {

                            $Ar = \explode(',', $record['serv']);

                            foreach ($Ar as $item) {

                                $id = ArrayHelper::getValue(Service::find()->where(['value' => $item])->asArray()->one(), 'id');

                                if ($id) {

                                    $userRayon = new UserService();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->service_id = $id;
                                    $userRayon->city_id = $city['id'];
                                    $userRayon->save();

                                }

                            }

                        }

                        else{

                            foreach ($serviceList as $serviceItem){

                                if (\rand(0, 3) == 3){

                                    $userRayon = new UserService();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->service_id = $serviceItem['id'];
                                    $userRayon->city_id = $city['id'];
                                    $userRayon->save();

                                }

                            }

                        }

                        if ($record['mini']) {

                            $userPhoto = new Files();

                            $userPhoto->related_id = $post->id;
                            $userPhoto->file = \str_replace('files', $this->path, $record['mini']);
                            $userPhoto->main = 1;
                            $userPhoto->type = 0;
                            $userPhoto->related_class = Posts::class;

                            $userPhoto->save();

                        }

                        if ($record['gallery']) {

                            $gall = \explode(',', $record['gallery']);

                            if ($gall) {

                                if (!$record['mini']){

                                    $mini = \array_shift($gall);

                                    $userPhoto = new Files();

                                    $userPhoto->related_id = $post->id;
                                    $userPhoto->file = \str_replace('files', $this->path, $mini);
                                    $userPhoto->main = 1;
                                    $userPhoto->type = 0;
                                    $userPhoto->related_class = Posts::class;

                                    $userPhoto->save();

                                }

                                foreach ($gall as $gallitem) {

                                    if ($gallitem) {

                                        $userPhoto = new Files();

                                        $userPhoto->related_id = $post->id;
                                        $userPhoto->file = \str_replace('files', $this->path, $gallitem);
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
                else
                    {

                    $post = new Posts();

                    $post->city_id = $city['id'];
                    $post->created_at = \time() - ((3600 * 24) * \rand(0, 365));
                    $post->name = $record['name'];
                    $post->updated_at = $this->update;
                    $post->phone = $record['phone'];
                    $post->about = $record['anket-about'];
                    $post->check_photo_status = 0;
                    $post->price = (int)$record['price'];
                    $post->age = $record['age'];
                    $post->rost = $record['rost'];
                    $post->breast = $record['grud'];
                    $post->ves = $record['weight'];
                    $post->category = Posts::INDI_CATEGORY;

                    if (isset($record['video']) and $record['video']) $post->video = \str_replace('files', $this->path, $record['video']);

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

                            }else{

                                $rayonId = new Rayon();

                                $rayonId->value = $record['rayon'];
                                $rayonId->city_id = $city['id'];
                                $rayonId->url = \trim($translit->translit($record['rayon'], true, 'ru-en'));

                                $rayonId->save();

                                $userRayon = new UserRayon();
                                $userRayon->post_id = $post->id;
                                $userRayon->rayon_id = $rayonId->id;
                                $userRayon->city_id = $city['id'];
                                $userRayon->save();

                            }

                        }

                        if (isset($record['metro']) and $record['metro']) {

                            $metro = \explode(',', $record['metro']);

                            if ($metro) {

                                foreach ($metro as $metroItem){

                                    $id = ArrayHelper::getValue(Metro::find()
                                        ->where(['value' => $metroItem])
                                        ->andWhere(['city_id' => $city['id']])
                                        ->asArray()->one(), 'id');

                                    if ($id) {

                                        $userRayon = new UserMetro();
                                        $userRayon->post_id = $post->id;
                                        $userRayon->metro_id = $id;
                                        $userRayon->city_id = $city['id'];
                                        $userRayon->save();

                                    }else{

                                        $metro = new Metro();

                                        $metro->value = $metroItem;
                                        $metro->city_id = $city['id'];
                                        $metro->url = \trim($translit->translit($metroItem, true, 'ru-en'));

                                        $metro->save();

                                        $userRayon = new UserMetro();
                                        $userRayon->post_id = $post->id;
                                        $userRayon->metro_id = $metro->id;
                                        $userRayon->city_id = $city['id'];
                                        $userRayon->save();

                                    }

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

                        if (isset($record['etik']) and $record['etik']) {

                            $id = ArrayHelper::getValue(National::find()->where(['value' => $record['etik']])->asArray()->one(), 'id');

                            if ($id) {

                                $userRayon = new UserNational();
                                $userRayon->post_id = $post->id;
                                $userRayon->national_id = $id;
                                $userRayon->city_id = $city['id'];
                                $userRayon->save();

                            }

                        }

                        if (isset($record['mesto']) and $record['mesto']) {

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

                        }else{

                            foreach ($placeList as $placeItem){

                                if (\rand(0,2) == 2){

                                    $userRayon = new UserPlace();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->place_id = $placeItem['id'];
                                    $userRayon->city_id = $city['id'];
                                    $userRayon->save();

                                }

                            }

                        }

                        if (isset($record['mass']) and $record['mass']) {

                            $Ar = \explode(',', $record['mass']);

                            foreach ($Ar as $item) {

                                $id = ArrayHelper::getValue(Service::find()->where(['value' => $item])->asArray()->one(), 'id');

                                if ($id) {

                                    $userRayon = new UserService();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->service_id = $id;
                                    $userRayon->city_id = $city['id'];
                                    $userRayon->save();

                                }

                            }

                        }

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

                        if (isset($record['serv']) and $record['serv']) {

                            $Ar = \explode(',', $record['serv']);

                            foreach ($Ar as $item) {

                                $id = ArrayHelper::getValue(Service::find()->where(['value' => $item])->asArray()->one(), 'id');

                                if ($id) {

                                    $userRayon = new UserService();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->service_id = $id;
                                    $userRayon->city_id = $city['id'];
                                    $userRayon->save();

                                }

                            }

                        }else{

                            foreach ($serviceList as $serviceItem){

                                if (\rand(0, 3) == 3){

                                    $userRayon = new UserService();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->service_id = $serviceItem['id'];
                                    $userRayon->city_id = $city['id'];
                                    $userRayon->save();

                                }

                            }

                        }

                        if ($record['mini']) {

                            $userPhoto = new Files();

                            $userPhoto->related_id = $post->id;
                            $userPhoto->file = \str_replace('files', $this->path, $record['mini']);
                            $userPhoto->main = 1;
                            $userPhoto->type = 0;
                            $userPhoto->related_class = Posts::class;

                            $userPhoto->save();

                        }

                        if ($record['gallery']) {

                            $gall = \explode(',', $record['gallery']);

                            if ($gall) {

                                if (!$record['mini']){

                                    $mini = \array_shift($gall);

                                    $userPhoto = new Files();

                                    $userPhoto->related_id = $post->id;
                                    $userPhoto->file = \str_replace('files', $this->path, $mini);
                                    $userPhoto->main = 1;
                                    $userPhoto->type = 0;
                                    $userPhoto->related_class = Posts::class;

                                    $userPhoto->save();

                                }

                                foreach ($gall as $gallitem) {

                                    if ($gallitem) {

                                        $userPhoto = new Files();

                                        $userPhoto->related_id = $post->id;
                                        $userPhoto->file = \str_replace('files', $this->path, $gallitem);
                                        $userPhoto->main = 0;
                                        $userPhoto->type = 0;
                                        $userPhoto->related_class = Posts::class;

                                        $userPhoto->save();

                                    }

                                }

                            }

                        }

                    }
                    else {
                        \d($post->getErrors());
                    }

                }

            }


        }

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

        foreach ($posts as $post){

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

        foreach ($posts as $post){

            if ($files = Files::find()->where(['related_id' => $post['id'], 'related_class' => Posts::class])->all()){

                foreach ($files as $file){

                    $file->file = \str_replace('aa2', 'aa3', $file->file);

                    $file->save();

                }

            }

        }
    }

    public function actionVideo()
    {
        $posts = Posts::find()->where(['updated_at' => 1])->all();

        foreach ($posts as $post){

            if($post['video']){

                $post->video = \str_replace('aa2', 'aa3', $post->video);

                $post->save();

            }

        }
    }

    public function actionAddServiceMarc()
    {
        $reviews = Review::find()->with('post')->asArray()->all();

        foreach ($reviews as $review){

            if ($review['post']['service']){

                foreach ($review['post']['service'] as $item){

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

        foreach ($posts as $post){

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

    public function actionDns(){

        $citys = include 'dns-city.php';

        $host = 'sex-true.com';
        $ip = '193.42.108.121';

        foreach ($citys as $city){

            $content = array(
                'type' => "A",
                'name' => $city,
                'content' => $ip,

            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.cloudflare.com/client/v4/zones/375e7fbf4f926ab5db1431f990329b80/dns_records");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($content));  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'X-Auth-Email: '.Yii::$app->params['cloud_email'],
                'X-Auth-Key: '.Yii::$app->params['cloud_api'],
                'Content-Type: application/json',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec ($ch);

            $object = json_decode($server_output);

            if (!isset($object->result->id)) continue;

            $zapid = $object->result->id;


            curl_close ($ch);

            // пытаемся поставить галочку на облаке
            $zoneindetif="https://api.cloudflare.com/client/v4/zones/375e7fbf4f926ab5db1431f990329b80/dns_records/$zapid";


            $content = array(
                'type' => "A",
                'name' => $city,
                'content' => $ip,
                'proxied' => true,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$zoneindetif);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($content));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'X-Auth-Email: '.Yii::$app->params['cloud_email'],
                'X-Auth-Key: '.Yii::$app->params['cloud_api'],
                'Content-Type: application/json',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec ($ch);

            echo $city.PHP_EOL;

        }

    }

    public function actionWebmaster()
    {
        $access_token = 'AgAAAABNB5owAAOcKnTtNSvAHEBslBQhuKfyGD8';
        $host = 'sex-true.com';

        $citys = City::find()->asArray()->all();

        foreach ($citys as $city){

            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept-language: en\r\n" .
                        "Cookie: foo=bar\r\n".
                        'Authorization: OAuth '.$access_token,
                )
            );

            $context = stream_context_create($opts);

            $user_id = file_get_contents("https://api.webmaster.yandex.net/v3/user/", false, $context);
            $user_id = json_decode($user_id);
            $user_id = $user_id->user_id;



            $content = '
                
                <Data>
                    <host_url>https://'.$city['url'].'.'.$host.'</host_url>
                </Data>
                
                ';



            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.webmaster.yandex.net/v4/user/{$user_id}/hosts/");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$content);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'Content-type: application/xml',
                'Authorization: OAuth '.$access_token
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec ($ch);

            curl_close ($ch);

            $result=json_decode($server_output);


            $content = '';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.webmaster.yandex.net/v3/user/{$user_id}/hosts/".urlencode($result->host_id)."/verification/?verification_type=META_TAG");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$content);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'Content-type: application/xml',
                'Authorization: OAuth '.$access_token
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec ($ch);

            curl_close ($ch);

            $server_output = json_decode($server_output);

            $meta2 =  $server_output->verification_uin;

            $meta_model = new Webmaster();

            $meta_model->city_id = $city['id'];
            $meta_model->tag = $meta2;

            $meta_model->save();

        }
    }

    public function actionAddService()
    {
        $newService = array('Cекс по телефону', 'Виртуальный секс', 'Игрушки', 'Клизма', 'Легкое подчинение',
            'Лесби откровенное', 'Порка', 'Профессиональный', 'Расслабляющий', 'Секс групповой', 'Секс лесбийский',
            'Стриптиз профи', 'Трамплинг', 'Услуги семейной паре', 'Фетиш', 'Фингеринг', 'Фото/видео съемка',
            'Целуюсь');

        foreach ($newService as $item){

            $translit = new Translit();

            if (!Service::find()->where(['value' => $item])->count()){

                $service = new Service();
                $service->value = $item;
                $service->url = \str_replace(' ', '-', \strtolower($translit->translit($item, false, 'ru-en')) );
                $service->save();

            }

        }

    }

}