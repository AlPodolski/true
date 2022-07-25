<?php

namespace frontend\controllers;

use common\models\City;
use common\models\Pol;
use frontend\helpers\MetaBuilder;
use frontend\models\UserMetro;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserPlace;
use Yii;
use frontend\controllers\BeforeController as Controller;
use yii\helpers\ArrayHelper;

class MapController extends Controller
{

    private $limit = 3000;
    private $columns = 'id, name, phone, price, x, y';

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600 * 24,
                'variations' => [
                    Yii::$app->request->url,
                    Yii::$app->request->hostInfo,
                ],
            ],
        ];

    }

    public function actionIndex($city)
    {

        $cityInfo = City::getCity($city);

        $uri = Yii::$app->request->url;

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        $posts = Posts::find()->asArray()
            ->with('avatar', 'metro')
            ->where(['city_id' => $cityInfo['id']])
            ->select($this->columns)
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy('id DESC')
            ->limit($this->limit)
            ->all();

        return $this->render('index', [
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
            'posts' => $posts,
        ]);
    }

    public function actionFilter($city)
    {

        $city = City::getCity($city);

        $params = Yii::$app->request->post();

        $ids = array();

        $id = UserMetro::find()
            ->andWhere(['city_id' => $city['id']])
            ->select('post_id')->asArray()->all();

        if ($id) {

            $result = ArrayHelper::getColumn($id, 'post_id');

            if (!empty($ids)) {

                $ids = array_intersect($ids, $result);

            } else {

                $ids = $result;

            }

        }

        if (empty($result)) {
            $ids = [
                '0' => 0
            ];
        }

        if ($params['place']) {

            $id = UserPlace::find()->where(['in', 'place_id', $params['place']])
                ->andWhere(['city_id' => $city['id']])
                ->select('post_id')->asArray()->all();

            if ($id) {

                $result = ArrayHelper::getColumn($id, 'post_id');

                if (!empty($ids)) {

                    $ids = array_intersect($ids, $result);

                } else {

                    $ids = $result;

                }

            }

            if (empty($result)) {
                $ids = [
                    '0' => 0
                ];
            }

        }

        if ($params['intimCut']) {

            $id = UserIntimHair::find()->where(['in', 'color_id', $params['intimCut']])
                ->select('post_id')->asArray()->all();

            if ($id) {

                $result = ArrayHelper::getColumn($id, 'post_id');

                if (!empty($ids)) {

                    $ids = array_intersect($ids, $result);

                } else {

                    $ids = $result;

                }

            }

            if (empty($result)) {
                $ids = [
                    '0' => 0
                ];
            }

        }

        if ($params['naci']) {

            $id = UserNational::find()->where(['in', 'national_id', $params['naci']])
                ->andWhere(['city_id' => $city['id']])
                ->select('post_id')->asArray()->all();

            if ($id) {

                $result = ArrayHelper::getColumn($id, 'post_id');

                if (!empty($ids)) {

                    $ids = array_intersect($ids, $result);

                } else {

                    $ids = $result;

                }

            }

            if (empty($result)) {
                $ids = [
                    '0' => 0
                ];
            }

        }

        if ($params['hair']) {

            $id = UserHairColor::find()->where(['in', 'hair_color_id', $params['hair']])
                ->andWhere(['city_id' => $city['id']])
                ->select('post_id')->asArray()->all();

            if ($id) {

                $result = ArrayHelper::getColumn($id, 'post_id');

                if (!empty($ids)) {

                    $ids = array_intersect($ids, $result);

                } else {

                    $ids = $result;

                }

            }

            if (empty($result)) {
                $ids = [
                    '0' => 0
                ];
            }

        }

        $posts = Posts::find()
            ->select($this->columns)
            ->with('metro', 'avatar')
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['city_id' => $city['id']]);

        if ($ids) $posts = $posts->andWhere(['in', 'id', $ids])->orderBy(Posts::getOrder());

        $posts = $posts->andWhere(['>=', 'age', $params['age-from']])
            ->andWhere(['<=', 'age', $params['age-to']])
            ->andWhere(['>=', 'rost', $params['rost-from']])
            ->andWhere(['<=', 'rost', $params['rost-to']])
            ->andWhere(['>=', 'ves', $params['ves-from']])
            ->andWhere(['<=', 'ves', $params['ves-to']])
            ->andWhere(['>=', 'breast', $params['grud-from']])
            ->andWhere(['<=', 'breast', $params['grud-to']])
            ->andWhere(['>=', 'price', $params['price-1-from']])
            ->andWhere(['<=', 'price', $params['price-1-to']]);

        if ($params['check-photo']) $posts = $posts->andWhere(['check_photo_status' => 1]);
        if ($params['video']) $posts = $posts->andWhere(['<>', 'video', '']);

        $posts = $posts->limit($this->limit)->asArray()->all();

        $result = [];

        foreach ($posts as $post) {

            if (isset($post['metro'][0]['x']) and $post['metro'][0]['x'] and $post['avatar']) {

                $post['name'] = preg_replace('/[^ a-zа-яё\d]/ui', '', $post['name']);

                $result[] = $post;

            }

        }

        return json_encode($result);

    }

}