<?php


namespace frontend\controllers;

use common\models\City;
use frontend\helpers\MetaBuilder;
use frontend\helpers\QueryParamsHelper;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;

class FilterController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600 *24,
                'variations' => [
                    Yii::$app->request->url,
                    Yii::$app->request->post('page'),
                    Yii::$app->request->hostInfo,
                ],
            ],
        ];

    }

    public function actionIndex($city, $param, $page = false)
    {

        $query_params = QueryParamsHelper::getParams($param, $city);

        $posts = '';

        $cityInfo = City::getCity(Yii::$app->controller->actionParams['city']);

        if (!empty($query_params)){

            $posts = Posts::find();

            foreach ($query_params as $item){

                $posts->andWhere($item);

            }

            $posts = $posts->limit(Yii::$app->params['post_limit'])
                ->with('avatar', 'metro', 'selphiCount')
                ->andWhere(['city_id' => $cityInfo['id']])
                ->asArray();

            if ($page) $posts = $posts->offset(Yii::$app->params['post_limit'] * 1);

            if (strpos($param, 'page')) $param = strstr($param, '/page' , true);

            if (Yii::$app->request->isPost){

                $posts->offset(Yii::$app->params['post_limit'] * Yii::$app->request->post('page'));

                $posts = $posts->all();

                if (\count($posts)) {

                    $page = Yii::$app->request->post('page') + 1;

                    echo '<div data-url="/'.$param.'/page-'.$page.'" class="col-12"></div>';

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

            $posts = $posts->all();


        }

        $more_posts = false;

        $uri = Yii::$app->request->url;

        if (\strpos($uri, 'page')) $uri = \strstr($uri, '/page', true);


        $title =  MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        return $this->render('index', [
            'posts' => $posts,
            'city' => $city,
            'param' => $param,
            'cityInfo' => $cityInfo,
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
        ]);
    }
}