<?php

namespace frontend\controllers;

use common\models\City;
use common\models\Pol;
use frontend\helpers\MetaBuilder;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;

class MapController extends Controller
{
    public function actionIndex($city)
    {

        $cityInfo = City::getCity($city);

        $uri = Yii::$app->request->url;

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        $posts = Posts::find()->asArray()
            ->with('avatar', 'metro' )
            ->where(['city_id' => $cityInfo['id']])
            ->select('id, name, phone, price')
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy('id DESC')
            ->limit(4500)
            ->all();

        return $this->render('index', [
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
            'posts' => $posts,
        ]);
    }
}