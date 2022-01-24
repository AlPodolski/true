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

            foreach ($timeList as $item){

                if (\rand(0, 1) == 0 and $post->city_id) {

                    $userTime = new UserTime();

                    $userTime->param_id = $item['id'];

                    $userTime->post_id = $post->id;

                    $userTime->city_id = $post->city_id;

                    $userTime->save();


                }

            }

        }

    }
}