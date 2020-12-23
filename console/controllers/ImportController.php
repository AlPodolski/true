<?php

namespace console\controllers;

use common\models\City;
use common\models\HairColor;
use common\models\National;
use common\models\Osobenosti;
use common\models\Place;
use common\models\Rayon;
use common\models\Service;
use common\models\User;
use frontend\models\Files;
use frontend\models\Metro;
use frontend\models\UserMetro;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\PostSites;
use frontend\modules\user\models\Review;
use frontend\modules\user\models\ServiceReviews;
use frontend\modules\user\models\UserHairColor;
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
    public function actionIndex()
    {
        $stream = \fopen(Yii::getAlias('@app/files/prostitutkimoskvylucky_22_12_2020.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $placeList = Place::find()->asArray()->all();
        $serviceList = Service::find()->asArray()->all();

        foreach ($records as $record) {

            if ($record['phone']) {

                if ($post = Posts::find()->where(['like', 'phone', $record['phone']])->one()) {

                    $postSite = new PostSites();

                    $postSite->post_id = $post->id;
                    $postSite->site_id = 3;
                    $postSite->price = $post->price;
                    $postSite->created_at = $post->created_at;
                    $postSite->name_on_site = $post->name;
                    $postSite->age = $post->age;

                    $postSite->save();

                    $post->video = \str_replace('files', '/uploads/aa2', $record['video']);

                    $post->save();

                }
                else
                    {

                    $post = new Posts();

                    $post->city_id = 1;
                    $post->created_at = \time() - ((3600 * 24) * \rand(0, 365));
                    $post->name = $record['name'];
                    $post->updated_at = 2;
                    $post->phone = $record['phone'];
                    $post->about = $record['anket-about'];
                    $post->check_photo_status = 0;
                    $post->price = (int)$record['price'];
                    $post->age = $record['age'];
                    $post->rost = $record['rost'];
                    $post->breast = $record['grud'];
                    $post->ves = $record['weight'];
                    $post->category = Posts::INDI_CATEGORY;

                    if (isset($record['cheked']) and $record['cheked'] == 1) $post->check_photo_status = 1;

                    if ($post->save()) {

                        $postSite = new PostSites();

                        $postSite->post_id = $post->id;
                        $postSite->site_id = 3;
                        $postSite->price = $post->price;
                        $postSite->created_at = $post->created_at;
                        $postSite->name_on_site = $post->name;
                        $postSite->age = $post->age;

                        $postSite->save();

                        if (isset($record['rayon']) and $record['rayon']) {

                            $rayonId = ArrayHelper::getValue(Rayon::find()->where(['value' => $record['rayon']])->asArray()->one(), 'id');

                            if ($rayonId) {

                                $userRayon = new UserRayon();
                                $userRayon->post_id = $post->id;
                                $userRayon->rayon_id = $rayonId;
                                $userRayon->city_id = 1;
                                $userRayon->save();

                            }

                        }

                        if (isset($record['metro']) and ['metro']) {

                            $id = ArrayHelper::getValue(Metro::find()->where(['value' => $record['metro']])->asArray()->one(), 'id');

                            if ($id) {

                                $userRayon = new UserMetro();
                                $userRayon->post_id = $post->id;
                                $userRayon->metro_id = $id;
                                $userRayon->city_id = 1;
                                $userRayon->save();

                            }

                        }

                        if (isset($record['hair']) and $record['hair']) {

                            $id = ArrayHelper::getValue(HairColor::find()->where(['value' => $record['hair']])->asArray()->one(), 'id');

                            if ($id) {

                                $userRayon = new UserHairColor();
                                $userRayon->post_id = $post->id;
                                $userRayon->hair_color_id = $id;
                                $userRayon->city_id = 1;
                                $userRayon->save();

                            }

                        }

                        if (isset($record['ethnik']) and $record['ethnik']) {

                            $id = ArrayHelper::getValue(National::find()->where(['value' => $record['ethnik']])->asArray()->one(), 'id');

                            if ($id) {

                                $userRayon = new UserNational();
                                $userRayon->post_id = $post->id;
                                $userRayon->national_id = $id;
                                $userRayon->city_id = 1;
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
                                    $userRayon->city_id = 1;
                                    $userRayon->save();

                                }

                            }

                        }else{

                            foreach ($placeList as $placeItem){

                                if (\rand(0,2) == 2){

                                    $userRayon = new UserPlace();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->place_id = $placeItem['id'];
                                    $userRayon->city_id = 1;
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
                                    $userRayon->city_id = 1;
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
                                    $userRayon->city_id = 1;
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
                                    $userRayon->city_id = 1;
                                    $userRayon->save();

                                }

                            }

                        }else{

                            foreach ($serviceList as $serviceItem){

                                if (\rand(0, 3) == 3){

                                    $userRayon = new UserService();
                                    $userRayon->post_id = $post->id;
                                    $userRayon->service_id = $serviceItem['id'];
                                    $userRayon->city_id = 1;
                                    $userRayon->save();

                                }

                            }

                        }

                        if ($record['mini']) {

                            $userPhoto = new Files();

                            $userPhoto->related_id = $post->id;
                            $userPhoto->file = \str_replace('files', '/uploads/aa2', $record['mini']);
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
                                    $userPhoto->file = \str_replace('files', '/uploads/aa2', $mini);
                                    $userPhoto->main = 1;
                                    $userPhoto->type = 0;
                                    $userPhoto->related_class = Posts::class;

                                    $userPhoto->save();

                                }

                                foreach ($gall as $gallitem) {

                                    if ($gallitem) {

                                        $userPhoto = new Files();

                                        $userPhoto->related_id = $post->id;
                                        $userPhoto->file = \str_replace('files', '/uploads/aa2', $gallitem);
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
            $postSite->site_id = 2;
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

}