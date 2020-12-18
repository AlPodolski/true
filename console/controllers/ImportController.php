<?php

namespace console\controllers;

use common\models\City;
use common\models\HairColor;
use common\models\National;
use common\models\Osobenosti;
use common\models\Place;
use common\models\Rayon;
use common\models\Service;
use frontend\models\Files;
use frontend\models\Metro;
use frontend\models\UserMetro;
use frontend\modules\user\models\Photo;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\PostSites;
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
        $stream = \fopen(Yii::getAlias('@app/files/import_rachcom_17_12_2020.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        foreach ($records as $record) {

            $post  = new Posts();

            $post->city_id = 1;
            $post->created_at = \time() - ((3600 * 24) * \rand(0, 365));
            $post->name = $record['name'];
            $post->phone = $record['phone'];
            $post->about = $record['anket-about'];
            $post->check_photo_status = 0;
            $post->price = $record['price'];
            $post->age = $record['age'];
            $post->rost = $record['rost'];
            $post->breast = $record['grud'];
            $post->ves = $record['weight'];
            $post->category = Posts::INDI_CATEGORY;

            if ($post->save()){

                if ($record['rayon']){

                    $rayonId = ArrayHelper::getValue(Rayon::find()->where(['value' => $record['rayon']])->asArray()->one(), 'id');

                    if ($rayonId){

                        $userRayon = new UserRayon();
                        $userRayon->post_id = $post->id;
                        $userRayon->rayon_id = $rayonId;
                        $userRayon->city_id = 1;
                        $userRayon->save();

                    }

                }

                if ($record['metro']){

                    $id = ArrayHelper::getValue(Metro::find()->where(['value' => $record['metro']])->asArray()->one(), 'id');

                    if ($id){

                        $userRayon = new UserMetro();
                        $userRayon->post_id = $post->id;
                        $userRayon->metro_id = $id;
                        $userRayon->city_id = 1;
                        $userRayon->save();

                    }

                }
                if ($record['hair']){

                    $id = ArrayHelper::getValue(HairColor::find()->where(['value' => $record['hair']])->asArray()->one(), 'id');

                    if ($id){

                        $userRayon = new UserHairColor();
                        $userRayon->post_id = $post->id;
                        $userRayon->hair_color_id = $id;
                        $userRayon->city_id = 1;
                        $userRayon->save();

                    }

                }
                if ($record['ethnik']){

                    $id = ArrayHelper::getValue(National::find()->where(['value' => $record['ethnik']])->asArray()->one(), 'id');

                    if ($id){

                        $userRayon = new UserNational();
                        $userRayon->post_id = $post->id;
                        $userRayon->national_id = $id;
                        $userRayon->city_id = 1;
                        $userRayon->save();

                    }

                }
                if ($record['mesto']){

                    $placeAr = \explode(',', $record['mesto']);

                    foreach ($placeAr as $item){

                        $id = ArrayHelper::getValue(Place::find()->where(['value' => $item])->asArray()->one(), 'id');

                        if ($id){

                            $userRayon = new UserPlace();
                            $userRayon->post_id = $post->id;
                            $userRayon->place_id = $id;
                            $userRayon->city_id = 1;
                            $userRayon->save();

                        }

                    }

                }
                if ($record['mass']){

                    $Ar = \explode(',', $record['mass']);

                    foreach ($Ar as $item){

                        $id = ArrayHelper::getValue(Service::find()->where(['value' => $item])->asArray()->one(), 'id');

                        if ($id){

                            $userRayon = new UserService();
                            $userRayon->post_id = $post->id;
                            $userRayon->service_id = $id;
                            $userRayon->city_id = 1;
                            $userRayon->save();

                        }

                    }

                }
                if ($record['osob']){

                    $Ar = \explode(',', $record['osob']);

                    foreach ($Ar as $item){

                        $id = ArrayHelper::getValue(Osobenosti::find()->where(['value' => $item])->asArray()->one(), 'id');

                        if ($id){

                            $userRayon = new UserOsobenosti();
                            $userRayon->post_id = $post->id;
                            $userRayon->param_id = $id;
                            $userRayon->city_id = 1;
                            $userRayon->save();

                        }

                    }

                }
                if ($record['serv']){

                    $Ar = \explode(',', $record['serv']);

                    foreach ($Ar as $item){

                        $id = ArrayHelper::getValue(Service::find()->where(['value' => $item])->asArray()->one(), 'id');

                        if ($id){

                            $userRayon = new UserService();
                            $userRayon->post_id = $post->id;
                            $userRayon->service_id = $id;
                            $userRayon->city_id = 1;
                            $userRayon->save();

                        }

                    }

                }

                if ($record['mini']) {

                    $userPhoto = new Files();

                    $userPhoto->related_id = $post->id;
                    $userPhoto->file = \str_replace('files', '/uploads/aa1', $record['mini']);
                    $userPhoto->main = 1;
                    $userPhoto->type = 0;
                    $userPhoto->related_class = Posts::class;

                    $userPhoto->save();

                }

                if ($record['gallery']) {

                    $gall = \explode(',', $record['gallery']);

                    if ($gall) {

                        foreach ($gall as $gallitem) {

                            if ($gallitem) {

                                $userPhoto = new Files();

                                $userPhoto->related_id = $post->id;
                                $userPhoto->file = \str_replace('files', '/uploads/aa1', $gallitem);
                                $userPhoto->main = 1;
                                $userPhoto->type = 0;
                                $userPhoto->related_class = Posts::class;

                                $userPhoto->save();

                            }

                        }

                    }

                }

                $postSite = new PostSites();

                $postSite->post_id = $post->id;
                $postSite->site_id = 1;
                $postSite->price = $post->price;
                $postSite->created_at = $post->created_at;
                $postSite->name_on_site = $post->name;
                $postSite->age = $post->age;

                $postSite->save();

            }

        }

    }

    public function actionAddCheck()
    {
        $posts = Posts::find()->all();

        foreach ($posts as $post){

            if (\rand(0,3) == 3){

                $post->check_photo_status = 1;

                $post->save();

            }

        }
    }

}