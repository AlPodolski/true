<?php


namespace frontend\controllers;

use common\jobs\AddViewJob;
use common\models\City;
use frontend\components\helpers\GetAdvertisingPost;
use frontend\helpers\MetaBuilder;
use frontend\helpers\QueryParamsHelper;
use frontend\modules\user\models\Posts;
use frontend\repository\PostsRepository;
use Yii;
use yii\data\Pagination;
use frontend\controllers\BeforeController as Controller;
use yii\web\NotFoundHttpException;

class FilterController extends Controller
{

    private $postsRepository;

    public function beforeAction($action)
    {
        if ($action->id == 'index' or $action->id == 'more') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
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

        $this->postsRepository = new PostsRepository($cityInfo['id']);

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        if ($h1 == 'Проститутки') throw new NotFoundHttpException();

        $limit = Yii::$app->params['post_limit'];
        $offset = 0;

        if ($page) $offset = Yii::$app->params['post_limit'] * $page;

        $data = $this->postsRepository->getPostForFilter($param, $cityInfo['id'], $limit, $offset);

        $postsWithVideo = $this->postsRepository->getPostWithVideo();

        if (strpos($param, 'page')) $param = strstr($param, '/?page=', true);

        $more_posts = false;

        if (\count($data['posts']) < 6) $more_posts = $this->postsRepository->getMorePost($cityInfo['id']);

        $checkBlock = GetAdvertisingPost::get($cityInfo);
        if ($checkBlock) array_unshift($data['posts'], $checkBlock);

        return $this->render('index', [
            'posts' => $data['posts'],
            'param' => $param,
            'pages' => $data['pages'],
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
            'postsWithVideo' => $postsWithVideo,
            'more_posts' => $more_posts,
        ]);

    }

    public function actionMore($city, $param)
    {

        if (Yii::$app->request->isPost and !Yii::$app->request->post('req')) exit();

        $cityInfo = City::getCity(Yii::$app->controller->actionParams['city']);

        $this->postsRepository = new PostsRepository($cityInfo['id']);

        $limit = Yii::$app->params['post_limit'];
        $offset = 0;

        $page = Yii::$app->request->post('page');

        if ($page) $offset = Yii::$app->params['post_limit'] * $page;

        $posts = $this->postsRepository->getPostForFilter($param, $cityInfo['id'], $limit, $offset);

        if (\count($posts)) {

            $page = Yii::$app->request->post('page') + 1;

        }

        return $this->renderPartial('more', [
            'posts' => $posts['posts'],
            'page' => $page,
            'param' => $param,
        ]);

    }
}