<?php

namespace cabinet\controllers;

use common\models\City;
use cabinet\components\helpers\GetOrderHelper;
use cabinet\helpers\MetaBuilder;
use cabinet\modules\user\models\Posts;
use Yii;

class PhotoController extends BeforeController
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

        $title = MetaBuilder::Build($uri, $city['url'], 'Title');
        $des = MetaBuilder::Build($uri, $city['url'], 'des');
        $h1 = MetaBuilder::Build($uri, $city['url'], 'h1');

        return $this->render('photo', compact('posts' , 'h1', 'title', 'des'));
    }
}