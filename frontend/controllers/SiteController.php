<?php

namespace frontend\controllers;

use common\models\City;
use frontend\helpers\MetaBuilder;
use frontend\helpers\FavoriteHelper;
use frontend\models\Webmaster;
use frontend\components\AuthHandler;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'frontend\components\AuthAction',
                'city' => Yii::$app->controller->actionParams['city'],
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'thumb' => 'iutbay\yii2imagecache\ThumbAction',
        ];
    }


/*    public function behaviors()
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

    }*/

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($city, $page = false)
    {

        $cityInfo = City::getCity($city);

        if (Yii::$app->request->isPost) {

            $posts = Posts::find()
                ->asArray()
                ->with('avatar', 'metro', 'selphiCount')
                ->where(['city_id' => $cityInfo['id']])
                ->limit(Yii::$app->params['post_limit']);

            $posts->offset(Yii::$app->params['post_limit'] * Yii::$app->request->post('page'));

            $posts = $posts->all();

            $page = Yii::$app->request->post('page') + 1;

            if ($posts) echo '<div data-url="/page-' . $page . '" class="col-12"></div>';

            foreach ($posts as $post) {

                echo $this->renderFile('@app/views/layouts/article.php', [
                    'post' => $post,
                ]);

            }

            exit();

        }

        $webmaster = Webmaster::getTag($cityInfo['id']);

        $prPosts = Posts::find()->asArray()
            ->with('avatar', 'metro', 'selphiCount')
            ->where(['city_id' => $cityInfo['id']])
            ->limit(11)->cache(3600)
            ->all();

        $checkBlock['block']['post'] = Posts::find()->asArray()
            ->where(['id' => 34])
            ->with('avatar')
            ->cache(3600)->one();

        $checkBlock['block']['header'] = 'Проверенные проститутки с высоким рейтингом';
        $checkBlock['block']['text'] = 'Рейтинг составляется на основе алгоритма
                и ручной модерации мы выбираем только
                качественные анкеты со всего интернета
                что бы показать их вам.';
        $checkBlock['block']['url'] = 'proverennye';

        $prPosts[] = $checkBlock;

        $uri = Yii::$app->request->url;

        if (\strpos($uri, 'page')) $uri = \strstr($uri, 'page', true);

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        \shuffle($prPosts);

        return $this->render('index', [
            'prPosts' => $prPosts,
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
            'webmaster' => $webmaster,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionFavorite($city)
    {
        return FavoriteHelper::Favorite(Yii::$app->request->post('id'));
    }

    public function actionRobot($city)
    {
        $host = $city . '.' . Yii::$app->params['site_name'];

        return $this->renderFile('@app/views/site/robot.php', [
            'host' => $host
        ]);
    }

    public function actionCust()
    {

    }

}
