<?php

namespace frontend\controllers;

use common\components\service\history\HistoryService;
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
use frontend\models\forms\PayForm;
use frontend\models\Metro;
use frontend\models\Webmaster;
use frontend\components\AuthHandler;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use Yii;
use frontend\modules\user\components\obmenka\Obmenka;
use yii\base\BaseObject;
use yii\data\Pagination;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    const OBMENKA_PAY = 'pay';

    public function init()
    {
        $this->on(self::OBMENKA_PAY, [HistoryService::class, 'addToHistory']);

        parent::init();
    }

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

            $ids = \json_decode(Yii::$app->request->post('id'));

            $posts = Posts::find()
                ->asArray()
                ->with('avatar', 'metro', 'selphiCount', 'partnerId')
                ->where(['city_id' => $cityInfo['id']])
                ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                ->andWhere(['not in' , 'id', $ids])
                ->andWhere(['pol_id' => Pol::WOMAN_POL])
                ->orderBy(Posts::getOrder())
                ->limit(Yii::$app->params['post_limit']);

            $posts->offset(Yii::$app->params['post_limit'] * Yii::$app->request->post('page'));

            $posts = $posts->all();

            $page = Yii::$app->request->post('page') + 1;

            if ($posts) echo '<div data-url="/?page=' . $page . '" class="col-12"></div>';

            foreach ($posts as $post) {

                ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']);

                echo $this->renderFile('@app/views/layouts/article.php', [
                    'post' => $post,
                ]);

            }

            exit();

        }

        $webmaster = Webmaster::getTag($cityInfo['id']);

        //Yii::$app->cache->flush();

        $prPosts = Posts::find()->asArray()
            ->with('avatar', 'metro', 'selphiCount' , 'partnerId')
            ->where(['city_id' => $cityInfo['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['pol_id' => Pol::WOMAN_POL])
            ->limit(Yii::$app->params['post_limit'])
            //->cache(3600)
            ->orderBy(Posts::getOrder());


        $countQuery = clone $prPosts;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => Yii::$app->params['post_limit']]);

        $prPosts = $prPosts->offset($pages->offset)->all();

        $checkBlock = GetAdvertisingPost::get($cityInfo);

        array_unshift($prPosts, $checkBlock);

        $uri = Yii::$app->request->url;

        if (\strpos($uri, 'page')) $uri = \strstr($uri, '?page', true);

        $title = MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        $topPostList = Posts::getTopList($cityInfo['id']);

        return $this->render('index', [
            'prPosts' => $prPosts,
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
            'topPostList' => $topPostList,
            'webmaster' => $webmaster,
            'pages' => $pages,
        ]);
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

        $posts = Posts::find()->where(['in', 'id', FavoriteHelper::getFavorite()])->with('avatar', 'metro', 'selphiCount', 'partnerId')
            ->all();

        return $this->render('favorite', [
            'posts' => $posts,
        ]);
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

    public function actionObmenkaPay($city,$protocol, $id)
    {

        if ($order = ObmenkaOrder::findOne(\str_replace(Yii::$app->params['obm-id-pref'],'' , $id))
            and $order['status'] == ObmenkaOrder::WAIT
            and $user = User::findOne($order['user_id'])){

            $obmenka = new Obmenka();

            $data = $obmenka->getOrderInfo($id.'-'.Yii::$app->params['obm-id-pref']);

            if (isset($data->amount) and $data->status == 'FINISHED'){

                $transaction = Yii::$app->db->beginTransaction();

                $order->status = ObmenkaOrder::FINISH;

                $user->cash = $user->cash + (int) $order->sum;

                if ($user->save() and $order->save()) {

                    $transaction->commit();

                    $billPayEvent = new BillPayEvent();

                    $billPayEvent->user_id = $user->id;
                    $billPayEvent->sum = (int) $order->sum;
                    $billPayEvent->type = History::BALANCE_REPLENISHMENT;
                    $billPayEvent->balance = $user->cash;

                    $this->trigger(self::OBMENKA_PAY, $billPayEvent);

                    Yii::$app->session->setFlash('success', 'Оплата совершена успешно');

                    return  $this->redirect($protocol.'://'.$city.'.'.Yii::$app->params['site_name']);

                }

                else{

                    $transaction->rollBack();

                    Yii::$app->session->setFlash('warning', 'Ошибка');

                    return  $this->redirect($protocol.'://'.$city.'.'.Yii::$app->params['site_name']);

                }

            }

        }

        return  $this->redirect($protocol.'://moskva.'.Yii::$app->params['site_name']);

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
        ]);

    }

}
