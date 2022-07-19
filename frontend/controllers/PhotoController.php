<?php

namespace frontend\controllers;

use common\models\City;
use frontend\components\helpers\GetOrderHelper;
use frontend\helpers\MetaBuilder;
use frontend\modules\user\models\Posts;
use yii\web\Controller;
use Yii;

class PhotoController extends Controller
{
    public function actionIndex($city)
    {

        $city = City::getCity($city);

        $posts = Posts::find()
            ->where(['status' => Posts::POST_ON_PUPLICATION_STATUS, 'city_id' => $city['id']])
        ->orderBy((new GetOrderHelper)->get())
        ->limit(40)
        ->with('avatar', 'gallery')->all();

        $uri = Yii::$app->request->url;

        if (\strpos($uri, 'page')) $uri = \strstr($uri, '?page', true);

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        return $this->render('photo', compact('posts' , 'h1', 'title', 'des'));
    }
}