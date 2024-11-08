<?php

namespace frontend\controllers;

use common\components\service\history\HistoryService;
use common\components\service\PayCount;
use common\jobs\AddViewJob;
use common\jobs\SendMail;
use common\models\City;
use common\models\HairColor;
use common\models\History;
use common\models\IntimHair;
use common\models\National;
use common\models\ObmenkaOrder;
use common\models\Osobenosti;
use common\models\Place;
use common\models\Pol;
use common\models\Rayon;
use common\models\Service;
use common\models\User;
use frontend\components\events\BillPayEvent;
use frontend\components\helpers\GetAdvertisingPost;
use frontend\helpers\MetaBuilder;
use frontend\helpers\FavoriteHelper;
use frontend\helpers\shema\CatalogProductShema;
use frontend\models\forms\PayForm;
use frontend\models\Metro;
use frontend\models\Webmaster;
use frontend\components\AuthHandler;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use frontend\repository\PostsRepository;
use Yii;
use frontend\modules\user\components\obmenka\Obmenka;
use yii\base\BaseObject;
use yii\data\Pagination;
use frontend\controllers\BeforeController as Controller;
use yii\queue\Queue;

/**
 * Site controller
 */
class SiteController extends Controller
{

    const OBMENKA_PAY = 'pay';

    public function init()
    {
        $this->on(self::OBMENKA_PAY, [HistoryService::class, 'addToHistory']);
        $this->on(self::OBMENKA_PAY, [PayCount::class, 'handle']);

        parent::init();
    }

    public function beforeAction($action)
    {
        if ($action->id == 'pay' or $action->id == 'index' or $action->id == 'more') {
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


    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['map', 'robot', 'map'],
                'duration' => 30,
                'variations' => [
                    Yii::$app->request->url,
                    Yii::$app->request->post('page'),
                    Yii::$app->request->hostInfo,
                    Yii::$app->request->isPost,
                ],
            ],
        ];

    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($city, $page = false, $pager = false)
    {

        $cityInfo = City::getCity($city);

        $postRepository = new PostsRepository($cityInfo['id']);

        if (Yii::$app->requestedParams['actual_city'] != $city) {
            $webmaster = Webmaster::getTagByName(Yii::$app->requestedParams['actual_city']);
        } else {
            $webmaster = Webmaster::getTag($cityInfo['id']);
        }

        $data = $postRepository->getForMainPage();

        $postsWithVideo = $postRepository->getPostWithVideo();

        $checkBlock = GetAdvertisingPost::get($cityInfo);

        if ($checkBlock) array_unshift($data['posts'], $checkBlock);

        $uri = Yii::$app->request->url;

        if (\strpos($uri, '?')) $uri = \strstr($uri, '?', true);

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        $microdataForMainPage = (new CatalogProductShema($title, $des, $cityInfo['id']))->make();

        Yii::$app->queueView->push(new AddViewJob([
            'posts' => $data['posts'],
            'type' => 'redis_post_listing_view_count_key',
        ]));

        return $this->render('index', [
            'prPosts' => $data['posts'],
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
            'webmaster' => $webmaster,
            'pages' => $data['pages'],
            'cityInfo' => $cityInfo,
            'postsWithVideo' => $postsWithVideo,
            'microdataForMainPage' => $microdataForMainPage,
        ]);
    }

    public function actionMore($city)
    {

        $cityInfo = City::getCity($city);

        $postRepository = new PostsRepository($cityInfo['id']);

        $posts = $postRepository->getMorePostsForMainPage($page = Yii::$app->request->post('page'));

        $topPostList = false;

        if ($page == 0) {

            $checkBlock = GetAdvertisingPost::get($cityInfo);

            if ($checkBlock) array_unshift($posts, $checkBlock);

            $topPostList = Posts::getTopList($cityInfo['id']);

        }

        Yii::$app->queueView->push(new AddViewJob([
            'posts' => $posts,
            'type' => 'redis_post_listing_view_count_key',
        ]));

        $page = $page + 1;

        return $this->renderFile('@app/views/site/more.php', compact(
            'page',
            'posts',
            'topPostList'
        ));

    }

    /**
     *
     * @return mixed
     */
    public function actionFavorite($city)
    {
        return FavoriteHelper::Favorite(Yii::$app->request->post('id'));
    }

    /**
     *
     * @return mixed
     */
    public function actionListFavorite($city)
    {

        $posts = Posts::find()->where(['in', 'id', FavoriteHelper::getFavorite()])
            ->with('avatar', 'metro', 'selphiCount', 'partnerId')
            ->all();

        return $this->render('favorite', [
            'posts' => $posts,
        ]);
    }

    public function actionRobot($city)
    {
        $host = Yii::$app->requestedParams['actual_city'] . '.' . Yii::$app->params['site_name'];

        return $this->renderFile('@app/views/site/robot.php', [
            'host' => $host,
            'city' => $city,
        ]);
    }

    public function actionCust()
    {

    }

    public function actionObmenkaPay($city, $protocol, $id)
    {

        if ($order = ObmenkaOrder::findOne(\str_replace(Yii::$app->params['obm-id-pref'], '', $id))
            and $order['status'] == ObmenkaOrder::WAIT
            and $user = User::findOne($order['user_id'])) {

            $obmenka = new Obmenka();

            $data = $obmenka->getOrderInfo($id . '-' . Yii::$app->params['obm-id-pref']);

            if (isset($data->amount) and ($data->status == 'FINISHED' or $data->status == 'PAYED_RECALC')) {

                $transaction = Yii::$app->db->beginTransaction();

                $order->status = ObmenkaOrder::FINISH;

                $sum = $data->accrual_amount;

                if ($data->currency == 'USDT_TRC20') $sum = $sum * Yii::$app->params['usdt_curst'];

                $sum = (int)$sum;

                if ($sum >= Yii::$app->params['start_sum_for_bonus']) {

                    $bonus = ($sum / 100) * Yii::$app->params['pay_bonus_percent'];
                    $user->cash = $user->cash + (int)$bonus + $sum;

                } else {

                    $user->cash = $user->cash + $sum;

                }

                if ($user->status == User::STATUS_INACTIVE) {

                    $user->cash = $user->cash + 100;
                    $user->status = User::STATUS_ACTIVE;

                }

                if ($user->save() and $order->save()) {

                    $billPayEvent = new BillPayEvent();

                    $billPayEvent->user_id = $user->id;
                    $billPayEvent->sum = $sum;
                    $billPayEvent->type = History::BALANCE_REPLENISHMENT;
                    $billPayEvent->balance = $user->cash;

                    $this->trigger(self::OBMENKA_PAY, $billPayEvent);

                    $transaction->commit();

                    Yii::$app->session->setFlash('success', 'Оплата совершена успешно');

                    return $this->redirect($protocol . '://' . $city . '.' . Yii::$app->params['site_name']);

                } else {

                    $transaction->rollBack();

                    Yii::$app->session->setFlash('warning', 'Ошибка');

                    return $this->redirect($protocol . '://' . $city . '.' . Yii::$app->params['site_name']);

                }

            }

        }

        return $this->redirect($protocol . '://moskva.' . Yii::$app->params['site_name']);

    }

    public function actionPay()
    {

        if (Yii::$app->request->isPost) {

            $log_file = fopen(Yii::getAlias("@frontend/web/files/pay_log5.txt"), 'a+');
            fwrite($log_file, print_r($requestDAta = json_decode(file_get_contents('php://input')), true) . PHP_EOL);
            fwrite($log_file, print_r(getallheaders(), true) . PHP_EOL);
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

            if ($payForm->validate()) {

                if ($payForm->pay()) return true;

            } else {

                $log_file = fopen(Yii::getAlias("@frontend/web/files/error_log.txt"), 'a+');
                fwrite($log_file, print_r($requestDAta = json_decode(file_get_contents('php://input')), true) . PHP_EOL);
                fwrite($log_file, print_r($payForm->getErrors(), true) . PHP_EOL);
                fwrite($log_file, print_r(getallheaders(), true) . PHP_EOL);
                fclose($log_file);

            }

        }

        return 1;

    }

    public function actionMap($city)
    {

        $cityInfo = City::getCity($city);

        $metro = Metro::find()->where(['city_id' => $cityInfo['id']])->asArray()->all();
        $rayon = Rayon::find()->where(['city_id' => $cityInfo['id']])->asArray()->all();
        $service = Service::find()->asArray()->all();

        $place = Place::getPlace();
        $naci = National::getAll();
        $hair = HairColor::getAll();
        $intimHair = IntimHair::getAll();
        $osobenosti = Osobenosti::getAll();

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        $posts = Posts::find()->where(['city_id' => $cityInfo['id']])->asArray()->all();

        $host = Yii::$app->requestedParams['actual_city'] . '.' . Yii::$app->params['site_name'];

        return $this->renderFile(Yii::getAlias('@frontend/views/site/map.php'), [
            'metro' => $metro,
            'rayon' => $rayon,
            'service' => $service,
            'place' => $place,
            'naci' => $naci,
            'hair' => $hair,
            'intimHair' => $intimHair,
            'posts' => $posts,
            'osobenosti' => $osobenosti,
            'host' => $host,
        ]);

    }

    public function actionPhone($city)
    {

        $cityInfo = City::getCity($city);

        $posts = Posts::find()->asArray()
            ->with('avatar', 'metro', 'selphiCount', 'partnerId')
            ->where(['city_id' => $cityInfo['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->limit(Yii::$app->params['post_limit'])
            //->cache(3600)
            ->orderBy(Posts::getOrder());


        $countQuery = clone $posts;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'forcePageParam' => false,
            'defaultPageSize' => Yii::$app->params['post_limit']
        ]);

        if (Yii::$app->request->isPost) {

            $page = Yii::$app->request->post('page') + 1;

            $posts = $posts->offset(Yii::$app->params['post_limit'] * Yii::$app->request->post('page'))->all();

            if ($posts) echo '<div data-url="/phone?page=' . $page . '" class="col-12"></div>';

            foreach ($posts as $post) {

                ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']);

                echo $this->renderFile('@app/views/layouts/article-phone.php', \compact('post'));

            }

            exit();

        }

        $posts = $posts->offset($pages->offset)->all();

        $uri = Yii::$app->request->url;

        if (\strpos($uri, 'page')) $uri = \strstr($uri, '?page', true);

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        return $this->render('phone', \compact('posts', 'cityInfo', 'title', 'des', 'h1', 'pages'));


    }

}
