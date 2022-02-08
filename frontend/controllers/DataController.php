<?php


namespace frontend\controllers;

use common\models\City;
use frontend\widgets\DataWidget;
use Yii;
use yii\filters\VerbFilter;
use frontend\controllers\BeforeController as Controller;

class DataController extends Controller
{

    public function actionGet($city)
    {
        $data = Yii::$app->request->get('data');

        $cityInfo = City::getCity($city);

        return DataWidget::widget([
            'data' => $data,
            'dataGet' => Yii::$app->request->get(),
            'city_id' => $cityInfo['id']
        ]);
    }

}