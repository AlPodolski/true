<?php


namespace frontend\controllers;

use common\jobs\AddViewJob;
use common\models\City;
use frontend\components\helpers\GetAdvertisingPost;
use frontend\helpers\MetaBuilder;
use frontend\helpers\QueryParamsHelper;
use frontend\modules\user\models\Posts;
use Yii;
use yii\data\Pagination;
use frontend\controllers\BeforeController as Controller;
use yii\web\NotFoundHttpException;

class FilterController extends Controller
{

    public function beforeAction($action)
    {
        if ($action->id == 'index' or $action->id == 'more') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    /*    public function behaviors()
        {
            return [
                [
                    'class' => 'yii\filters\PageCache',
                    'only' => ['index'],
                    'duration' => 60,
                    'variations' => [
                        Yii::$app->request->url,
                        Yii::$app->request->post('page'),
                        Yii::$app->request->hostInfo,
                        Yii::$app->request->isPost,
                    ],
                ],
            ];

        }*/

    public function actionIndex($city, $param, $page = false)
    {

        if (Yii::$app->request->isPost and !Yii::$app->request->post('req')) exit();

        $uri = Yii::$app->request->url;
        if (\strpos($uri, '?')) $uri = \strstr($uri, '?', true);

        $cityInfo = City::getCity(Yii::$app->controller->actionParams['city']);

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des') ;
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        if ($h1 == 'Проститутки') throw new NotFoundHttpException();

        $limit = Yii::$app->params['post_limit'];
        $offset = 0;

        if ($page) $offset = Yii::$app->params['post_limit'] * $page;

        $posts = QueryParamsHelper::getPosts($param, $cityInfo['id'], $limit, $offset);

        if (strpos($param, 'page')) $param = strstr($param, '/?page=', true);

        $more_posts = false;

        $topPostList = Posts::getTopList($cityInfo['id']);

        if (\count($posts) < 6) $more_posts = Posts::find()->limit(Yii::$app->params['post_limit'])
            ->with('avatar', 'metro', 'selphiCount', 'partnerId')
            ->andWhere(['city_id' => $cityInfo['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy('RAND()')->all();

        $checkBlock = GetAdvertisingPost::get($cityInfo);
        if ($checkBlock) array_unshift($posts, $checkBlock);

        Yii::$app->queueView->push(new AddViewJob([
            'posts' => $posts,
            'type' => 'redis_post_listing_view_count_key',
        ]));

        return $this->render('index', [
            'posts' => $posts,
            'param' => $param,
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
            'topPostList' => $topPostList,
            'more_posts' => $more_posts,
        ]);

    }

    public function actionMore($city, $param)
    {

        if (Yii::$app->request->isPost and !Yii::$app->request->post('req')) exit();

        $cityInfo = City::getCity(Yii::$app->controller->actionParams['city']);

        $limit = Yii::$app->params['post_limit'];
        $offset = 0;

        $topPostList = false;

        $page = Yii::$app->request->post('page');

        if ($page) $offset = Yii::$app->params['post_limit'] * $page;

        $posts = QueryParamsHelper::getPosts($param, $cityInfo['id'], $limit, $offset);

        if (\count($posts)) {

            if (Yii::$app->request->post('page') == 0) {

                $checkBlock = GetAdvertisingPost::get($cityInfo);

                if ($checkBlock) array_unshift($posts, $checkBlock);

                $topPostList = Posts::getTopList($cityInfo['id']);

            }

            $page = Yii::$app->request->post('page') + 1;

        }

        Yii::$app->queueView->push(new AddViewJob([
            'posts' => $posts,
            'type' => 'redis_post_listing_view_count_key',
        ]));

        return $this->renderPartial('more', compact('posts', 'topPostList', 'page', 'param'));

    }
}