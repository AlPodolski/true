<?php
namespace backend\controllers;

use common\models\CashCount;
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

        $payCountWeek = CashCount::find()->limit(7)->orderBy('id DESC')->all();

        $monthCash = CashCount::find()
            ->andWhere(['like','date', date('m-Y')])
            ->sum('count');

        return $this->render('index', compact('payCountWeek', 'monthCash'));

    }

    public function actionDropCache()
    {
        Yii::$app->cache->flush();

        Yii::$app->session->setFlash('success', 'Кеш удален');

        return $this->goHome();
    }

}
