<?php


namespace console\controllers;

use common\models\IntimHair;
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
        $posts = Posts::find()->with('strizhka')->all();

        $intimHair = IntimHair::find()->select('id')->asArray()->all();

        foreach ($posts as $post){

            if (!$post->strizhka) {

                $userStr = new UserIntimHair();

                $userStr->post_id = $post->id;

                $userStr->color_id = $intimHair[\array_rand($intimHair)]['id'];

                $userStr->save();

            }

        }
    }
}