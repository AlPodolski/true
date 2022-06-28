<?php
namespace backend\controllers;

use common\models\CashCount;
use common\models\PostCount;
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

        $registerCountWeek = PostCount::find()->limit(7)->orderBy('id DESC')->all();

        $monthRegister = PostCount::find()
            ->andWhere(['like','date', date('m-Y')])
            ->sum('count');

        $payCountWeek = CashCount::find()->limit(7)->orderBy('id DESC')->all();

        $monthCash = CashCount::find()
            ->andWhere(['like','date', date('m-Y')])
            ->sum('count');

        return $this->render('index',
            compact('payCountWeek', 'monthCash', 'monthRegister', 'registerCountWeek')
        );

    }

    public function actionDropCache()
    {
        Yii::$app->cache->flush();

        Yii::$app->session->setFlash('success', 'Кеш удален');

        return $this->goHome();
    }

}
