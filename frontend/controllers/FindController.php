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

        $this->enableCsrfValidation = false;

        $params = Yii::$app->request->get();

        $city = City::getCity($city);

        $ids = array();

        $filter = false;

        if ($params['metro']) {

            $filter = true;

            $id = UserMetro::find()->where(['metro_id' => $params['metro']])->select('post_id')->asArray()->all();

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

        $posts = Posts::find()->limit(Yii::$app->params['post_limit'])->andWhere(['city_id' => $city['id']]);
            if ($ids) $posts = $posts->andWhere(['in', 'id', $ids])->orderBy(Posts::getOrder());

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

        if (Yii::$app->request->isPost){

            $posts->offset(Yii::$app->params['post_limit'] * Yii::$app->request->post('page'));

            $posts = $posts->all();

            if (\count($posts)) {

                $page = Yii::$app->request->post('page') + 1;

                echo '<div data-url="/'.Yii::$app->request->url.'/page-'.$page.'" class="col-12"></div>';

            }

            if (Yii::$app->user->isGuest) $class = 'col-6 col-sm-6 col-md-4 col-lg-3';
            else $class = 'col-6 col-sm-6 col-md-4 col-lg-4';

            foreach ($posts as $post){

                echo $this->renderFile('@app/views/layouts/article.php', [
                    'post' => $post,
                    'cssClass' => $class,
                ]);

            }

            exit();

        }

        $posts = $posts
            ->with('avatar', 'metro', 'selphiCount', 'partnerId')
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
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