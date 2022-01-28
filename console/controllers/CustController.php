<?php


namespace console\controllers;

use common\models\IntimHair;
use common\models\Time;
use frontend\models\Metro;
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
        $posts = Posts::find()->where(['city_id' => 161])->all();

        $metroList = Metro::find()->where(['city_id' => $posts])->all();

        foreach ($posts as $post){

            $metroId = $metroList[\array_rand($metroList)];

            UserMetro::deleteAll(['post_id' => $post['id']]);

            $userMetro = new UserMetro();

            $userMetro->metro_id = $metroId['id'];
            $userMetro->post_id = $post['id'];
            $userMetro->city_id = 161;

            $userMetro->save();


        }

    }
}