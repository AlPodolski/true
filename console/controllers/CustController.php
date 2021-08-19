<?php


namespace console\controllers;

use backend\models\Posts;
use frontend\modules\user\models\PostSites;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;
use common\models\User;

class CustController extends Controller
{
    public function actionIndex()
    {
        $posts = Posts::findAll(['fake' => 0]);

        foreach ($posts as $post){

            if ($post->price > 1000 and $post->price < 2000) $post->price = $post->price - 500;
            elseif ($post->price >= 2000 and $post->price < 4000) $post->price = $post->price - 1000;
            elseif ($post->price >= 4000 and $post->price < 6000) $post->price = $post->price - 1500;
            elseif ($post->price >= 6000 and $post->price < 8000) $post->price = $post->price - 2000;
            elseif ($post->price > 8000) $post->price = $post->price - 3000;

            $post->save();

        }

    }
}