<?php

namespace frontend\controllers;

use common\models\City;
use frontend\helpers\MetaBuilder;
use frontend\helpers\FavoriteHelper;
use frontend\models\forms\PayForm;
use frontend\models\Webmaster;
use frontend\components\AuthHandler;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'pay') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
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
                ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                ->orderBy(['rand()' => SORT_DESC])
                ->limit(Yii::$app->params['post_limit']);

            $posts->offset(Yii::$app->params['post_limit'] * Yii::$app->request->post('page'));

            $posts = $posts->all();

            $page = Yii::$app->request->post('page') + 1;

            if ($posts) echo '<div data-url="/page-' . $page . '" class="col-12"></div>';

            foreach ($posts as $post) {

                ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']);

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
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->limit(11)->cache(3600)
            ->orderBy(['rand()' => SORT_DESC])
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

    public function actionPay()
    {

        if (Yii::$app->request->isPost){

            $log_file = fopen(Yii::getAlias("@frontend/web/files/pay_log5.txt"), 'a+');
            fwrite($log_file, print_r($requestDAta = json_decode(file_get_contents('php://input')), true).PHP_EOL);
            fwrite($log_file, print_r(getallheaders(), true).PHP_EOL);
            fclose($log_file);

            $sum = $requestDAta->bill->amount->value;
            $status = $requestDAta->bill->status->value;
            $user_id = $requestDAta->bill->customer->account;
            $billId = $requestDAta->bill->billId;

            $payForm = new PayForm();

            $payForm->user_id = $user_id;
            $payForm->status = $status;
            $payForm->sum = (int)\str_replace(' ', '', $sum);
            $payForm->bill_id = $billId;

            if ($payForm->validate()){

                if ($payForm->pay()) return true;

            }else{

                $log_file = fopen(Yii::getAlias("@frontend/web/files/error_log.txt"), 'a+');
                fwrite($log_file, print_r($requestDAta = json_decode(file_get_contents('php://input')), true).PHP_EOL);
                fwrite($log_file, print_r($payForm->getErrors(), true).PHP_EOL);
                fwrite($log_file, print_r(getallheaders(), true).PHP_EOL);
                fclose($log_file);

            }

        }

        return 1;

    }

}
