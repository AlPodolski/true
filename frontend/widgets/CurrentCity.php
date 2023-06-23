<?php


namespace frontend\widgets;

use common\models\City;
use frontend\models\Metro;
use Yii;
use yii\base\Widget;

class CurrentCity extends Widget
{
    public function run()
    {

        if (isset(Yii::$app->requestedParams) and $city = City::getCity(Yii::$app->requestedParams['city'])) {

            $cityList = City::find()->cache(3600* 24)->all();

            $metroList = Metro::getMetro($city['id']);

            return $this->render('city', compact('city', 'cityList', 'metroList'));

        }

    }
}