<?php


namespace frontend\controllers;

use frontend\widgets\DataWidget;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DataController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get' => ['POST'],
                ],
            ],
        ];
    }

    public function actionGet($city)
    {
        $data = Yii::$app->request->post('data');

        return DataWidget::widget(['data' => $data]);
    }

}