<?php


namespace console\controllers;

use common\models\IntimHair;
use common\models\Time;
use frontend\models\UserMetro;
use frontend\modules\user\models\Posts;
use common\models\City;
use common\models\Phone;
use frontend\modules\user\models\PostSites;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserService;
use frontend\modules\user\models\UserTime;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;
use common\models\User;

class CustController extends Controller
{
    public function actionIndex()
    {
        $posts = Posts::find()->all();

        $timeList = Time::getTime();

        foreach ($posts as $post){

            if (\rand(0, 1) and $post->city_id){

                $userService = new UserService();

                $userService->post_id = $post->id;
                $userService->city_id = $post->city_id;
                $userService->service_id = 51;
                $userService->save();

            }

        }

    }
}