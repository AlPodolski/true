<?php

namespace frontend\controllers;

use common\models\City;
use common\models\Rayon;
use common\models\Service;
use frontend\helpers\MetaBuilder;
use frontend\models\Metro;
use Yii;
use frontend\controllers\BeforeController as Controller;

class ServiceListController extends Controller
{

        public function behaviors()
       {
           return [
               [
                   'class' => 'yii\filters\PageCache',
                   'duration' => 3600 *48,
                   'variations' => [
                       Yii::$app->request->url,
                       Yii::$app->request->post('page'),
                       Yii::$app->request->hostInfo,
                   ],
               ],
           ];

       }

    public function actionRayon($city)
    {
        $cityInfo = City::getCity($city);

        $dataList = Rayon::find()->where(['city_id' => $cityInfo['id']])->with('posts')->all();

        $url = 'rayon';

        $uri = Yii::$app->request->url;

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        return $this->render('list',
            \compact('dataList', 'url', 'h1', 'des', 'title', 'cityInfo'));
    }

    public function actionMetro($city)
    {
        $cityInfo = City::getCity($city);

        $dataList = Metro::find()->where(['city_id' => $cityInfo['id']])->with('posts')->all();

        $url = 'metro';

        $uri = Yii::$app->request->url;

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        return $this->render('list',
            \compact('dataList', 'url', 'h1', 'des', 'title', 'cityInfo'));
    }

    public function actionService($city)
    {
        $cityInfo = City::getCity($city);

        $dataList = Service::find()->with('posts')->all();

        $url = 'usluga';

        $uri = Yii::$app->request->url;

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        return $this->render('list',
            \compact('dataList', 'url', 'h1', 'des', 'title', 'cityInfo'));
    }
}