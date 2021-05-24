<?php


namespace frontend\controllers;

use frontend\widgets\DataWidget;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DataController extends Controller
{

    public function actionGet($city)
    {
        $data = Yii::$app->request->get('data');

        return DataWidget::widget(['data' => $data, 'dataGet' => Yii::$app->request->get()]);
    }

}