<?php


namespace console\controllers;

use common\models\IntimHair;
use frontend\models\UserMetro;
use frontend\modules\user\models\Posts;
use common\models\City;
use common\models\Phone;
use frontend\modules\user\models\PostSites;
use frontend\modules\user\models\UserIntimHair;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;
use common\models\User;

class CustController extends Controller
{
    public function actionIndex()
    {
        $posts = Posts::find()->with('metro')->where(['<>' , 'city_id', 1])->all();

        foreach ($posts as $post){

            if ($post->metro) UserMetro::deleteAll(['post_id' => $post->id]);

        }

    }
}