<?php


namespace frontend\controllers;

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
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 1,
                'variations' => [
                    Yii::$app->request->url,
                    Yii::$app->request->post('page'),
                    Yii::$app->request->hostInfo,
                    Yii::$app->request->isPost,
                ],
            ],
        ];

    }

    public function actionIndex($city, $param, $page = false)
    {

        if (Yii::$app->request->isPost and !Yii::$app->request->post('req')) exit();

        $cityInfo = City::getCity(Yii::$app->controller->actionParams['city']);

        $limit = Yii::$app->params['post_limit'];
        $offset = 0;

        if (Yii::$app->request->isPost) {

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

                echo '<div data-url="/' . $param . '?page=' . $page . '" class="col-12"></div>';

            }

            return $this->renderPartial('more', compact('posts', 'topPostList', 'page'));

        }

        if ($page) $offset = Yii::$app->params['post_limit'] * $page;

        $posts = QueryParamsHelper::getPosts($param, $cityInfo['id'], $limit, $offset);

        if (strpos($param, 'page')) $param = strstr($param, '/?page=', true);

        $more_posts = false;

        $uri = Yii::$app->request->url;

        if (\strpos($uri, '?')) $uri = \strstr($uri, '?', true);


        $title = MetaBuilder::Build($uri, $city, 'Title') . ' На сайте ' . Yii::$app->request->serverName;
        $des = MetaBuilder::Build($uri, $city, 'des') . ' На сайте ' . Yii::$app->request->serverName;
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        $topPostList = Posts::getTopList($cityInfo['id']);

        if (\count($posts) < 6) $more_posts = false;

        $checkBlock = GetAdvertisingPost::get($cityInfo);
        if ($checkBlock) array_unshift($posts, $checkBlock);

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
}