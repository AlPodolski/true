<?php

namespace backend\controllers;

use backend\models\IpPhoneCount;
use common\models\BlockDomain;
use common\models\CashCount;
use common\models\City;
use common\models\CityBlock;
use common\models\PhoneView;
use common\models\PostCount;
use common\models\RealUserPhoneView;
use common\models\Spisaniya;
use common\models\UserCountRegister;
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
    public function behaviors()
    {
        return [
            \backend\components\behaviors\isAdminAuth::class,
        ];
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $postOnPublication = Posts::find()
            ->where(['status' => Posts::POST_ON_PUPLICATION_STATUS, 'fake' => 1])->count();

        $realPostCount = Posts::find()
            ->where(['fake' => 1])->count();

        $registerCountWeek = PostCount::find()->limit(7)->orderBy('id DESC')->all();

        $registerUserCountWeek = UserCountRegister::find()
            ->limit(7)->orderBy('id DESC')->all();

        $totalPhoneView = PhoneView::find()
            ->limit(7)
            ->orderBy('id DESC')
            ->all();

        $userPhoneView = RealUserPhoneView::find()
            ->limit(7)
            ->orderBy('id DESC')
            ->all();

        $ipPhoneViewCount = IpPhoneCount::find()
            ->limit(7)->orderBy('id DESC')->all();

        $monthRegister = PostCount::find()
            ->andWhere(['like','date', date('m-Y')])
            ->sum('count');

        $monthUserRegister = UserCountRegister::find()
            ->andWhere(['like','date', date('m-Y')])
            ->sum('count');

        $payCountWeek = CashCount::find()->limit(7)->orderBy('id DESC')->all();
        $spisaniyaCountWeek = Spisaniya::find()->limit(7)->orderBy('id DESC')->all();

        $monthCash = CashCount::find()
            ->andWhere(['like','date', date('m-Y')])
            ->sum('count');

        $monthCashSpis = Spisaniya::find()
            ->andWhere(['like','date', date('m-Y')])
            ->sum('count');

        $blockData = CityBlock::find()
            ->orderBy('id desc')
            ->with('check')
            ->limit(20)
            ->all();

        $sites = City::find()->groupBy('domain')->all();

        $blockDomains = BlockDomain::find()->all();

        return $this->render('index',
            compact('payCountWeek', 'monthCash', 'monthRegister',
                'registerCountWeek', 'monthUserRegister', 'registerUserCountWeek', 'postOnPublication',
            'realPostCount', 'ipPhoneViewCount', 'spisaniyaCountWeek', 'monthCashSpis', 'blockData',
                'totalPhoneView', 'userPhoneView', 'blockDomains', 'sites'
            )
        );

    }

    public function actionDropCache()
    {
        Yii::$app->cache->flush();

        Yii::$app->session->setFlash('success', 'Кеш удален');

        return $this->goHome();
    }

}
