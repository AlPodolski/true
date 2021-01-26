<?php


namespace frontend\controllers;

use common\models\City;
use frontend\helpers\MetaBuilder;
use frontend\models\UserMetro;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserRayon;
use frontend\modules\user\models\UserService;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class FindController extends Controller
{
    public function actionIndex($city)
    {

        $params = Yii::$app->request->get();

        $city = City::getCity($city);

        $ids = array();

        $filter = false;

        if ($params['metro']) {

            $filter = true;

            $id = UserMetro::find()->where(['id' => $params['metro']])->select('post_id')->asArray()->all();

            if ($id) {

                $result = ArrayHelper::getColumn($id, 'post_id');

                if (!empty($ids)) {

                    $ids = array_intersect($ids, $result);

                } else {

                    $ids = $result;

                }

            }

            if (empty($id)) {
                $ids = [
                    '0' => 0
                ];
            }

        }

        if ($params['rayon']) {

            $filter = true;

            $id = UserRayon::find()->where(['rayon_id' => $params['rayon']])->select('post_id')->asArray()->all();

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

        if ($params['service']) {

            $filter = true;

            $id = UserService::find()->where(['service_id' => $params['service']])
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

        if ($params['place']) {

            $filter = true;

            $id = UserPlace::find()->where(['place_id' => $params['place']])
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

        if ($params['naci']) {

            $filter = true;

            $id = UserNational::find()->where(['national_id' => $params['place']])
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

            $filter = true;

            $id = UserHairColor::find()->where(['hair_color_id' => $params['hair']])
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

        $posts = Posts::find();
            if ($ids) $posts = $posts->andWhere(['in', 'id', $ids]);

            $posts = $posts->andWhere(['>=' , 'age', $params['age-from']])
            ->andWhere(['<=' , 'age', $params['age-to']])
            ->andWhere(['>=' , 'rost', $params['rost-from']])
            ->andWhere(['<=' , 'rost', $params['rost-to']])
            ->andWhere(['>=' , 'ves', $params['ves-from']])
            ->andWhere(['<=' , 'ves', $params['ves-to']])
            ->andWhere(['>=' , 'breast', $params['grud-from']])
            ->andWhere(['<=' , 'breast', $params['grud-to']])
            ->andWhere(['>=' , 'price', $params['price-1-from']])
            ->andWhere(['<=' , 'price', $params['price-1-to']])
        ;

        if ($params['check-photo']) $posts = $posts->andWhere(['check_photo_status' => 1]);
        if ($params['video']) $posts = $posts->andWhere(['<>' , 'video' , '']);
        if ($params['new']) $posts = $posts->orderBy('id DESC');

        $posts = $posts
            ->with('avatar', 'metro', 'selphiCount')
            ->asArray()
            ->all();

        $title  = 'Поиск';
        $des    = 'Поиск';
        $h1     = 'Поиск по параметрам';

        return $this->render('index', [
            'posts' => $posts,
            'city' => $city,
            'param' => Yii::$app->request->url,
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
        ]);

    }

}