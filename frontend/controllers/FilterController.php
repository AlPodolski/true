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

    public function actionIndex($city, $param, $page = false, $pager = false)
    {

        if ($pager) {

            return $this->redirect('/'.$param.'?page='.$pager, 301);

        }

        $query_params = QueryParamsHelper::getParams($param, $city);

        $posts = '';

        $cityInfo = City::getCity(Yii::$app->controller->actionParams['city']);

        if (!$cityInfo) {
            http_response_code(502);
            exit();
        };

        if (!empty($query_params)){

            $posts = Posts::find();

            foreach ($query_params as $item){

                $posts->andWhere($item);

            }

            $posts = $posts->limit(Yii::$app->params['post_limit'])
                ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost', 'city', 'gallery', 'tarif')
                ->andWhere(['city_id' => $cityInfo['id']])
                ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                ->orderBy(Posts::getOrder())
                ->asArray();

            if (\strstr($param, 'novie')) $posts = $posts->orderBy('id DESC');

            if ($page) $posts = $posts->offset(Yii::$app->params['post_limit'] * 1);

            if (strpos($param, 'page')) $param = strstr($param, '/?page=' , true);

            if (Yii::$app->request->isPost){

                $posts->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                    ->offset(Yii::$app->params['post_limit'] * Yii::$app->request->post('page'));

                $posts = $posts->all();

                if (\count($posts)) {

                    $page = Yii::$app->request->post('page') + 1;

                    echo '<div data-url="/'.$param.'?page='.$page.'" class="col-12"></div>';

                }

                if (Yii::$app->user->isGuest) $class = 'col-6 col-sm-6 col-md-4 col-lg-3';
                else $class = 'col-6 col-sm-6 col-md-4 col-lg-4';

                foreach ($posts as $post){

                    echo $this->renderFile('@app/views/layouts/article.php', [
                        'post' => $post,
                        'cityInfo' => $cityInfo,
                        'cssClass' => $class,
                    ]);

                }

                exit();

            }

            $countQuery = clone $posts;

            $pages = new Pagination([
                'totalCount' => $count = $countQuery->cache(3600 * 12)->count(),
                'forcePageParam' => false,
                'defaultPageSize' => Yii::$app->params['post_limit']]);

            if (Yii::$app->request->get('page') and $count < ((Yii::$app->request->get('page') - 1) * Yii::$app->params['post_limit']))
                throw new NotFoundHttpException();

            $posts = $posts->offset($pages->offset);

            $posts = $posts->all();

            $more_posts = false;

            $uri = Yii::$app->request->url;

            if (\strpos($uri, '?')) $uri = \strstr($uri, '?', true);


            $title =  MetaBuilder::Build($uri, $city, 'Title'). ' На сайте '.Yii::$app->request->serverName;
            $des = MetaBuilder::Build($uri, $city, 'des'). ' На сайте '.Yii::$app->request->serverName;
            $h1 = MetaBuilder::Build($uri, $city, 'h1');

            $topPostList = Posts::getTopList($cityInfo['id']);

            if (\count($posts) < 6) $more_posts = Posts::find()->limit(Yii::$app->params['post_limit'])
                ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost')
                ->andWhere(['city_id' => $cityInfo['id']])
                ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                ->cache(3600 * 24)
                ->orderBy('RAND()')->all();

            $checkBlock = GetAdvertisingPost::get($cityInfo);
            if ($checkBlock) array_unshift($posts, $checkBlock);

            return $this->render('index', [
                'posts' => $posts,
                'param' => $param,
                'title' => $title,
                'des' => $des,
                'h1' => $h1,
                'topPostList' => $topPostList,
                'pages' => $pages,
                'more_posts' => $more_posts,
            ]);

        }

        throw new NotFoundHttpException();

    }
}