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
    public function actionIndex()
    {

        $cityList = array('Красноярск');

        foreach ($cityList as $item){

            if ($cityInfo = City::findOne(['city' => $item]) and $rayonList = Rayon::findAll(['city_id' => $cityInfo['id']])){

                if ($postsList = Posts::findAll(['city_id' => $cityInfo['id']])){

                    foreach ($postsList as $postItem){

                        $rayon = $rayonList[\array_rand($rayonList)];

                        $userRayon = new UserRayon();

                        $userRayon->city_id = $cityInfo['id'];
                        $userRayon->rayon_id = $rayon['id'];
                        $userRayon->post_id = $postItem['id'];

                        $userRayon->save();

                    }

                }

            }

        }

    }
}