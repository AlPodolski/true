<?php


namespace frontend\widgets;

use common\models\City;
use Yii;
use yii\base\Widget;

class CurrentCity extends Widget
{
    public function run()
    {

        if (isset(Yii::$app->requestedParams) and $city = City::getCity(Yii::$app->requestedParams['city'])) {

            if(\mb_strlen($city['city']) > 6) return \mb_substr($city['city'], 0, 6).'...';

            return $city['city'];

        }

        return false;

    }
}