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

            return $city['city'];

        }

        return false;

    }
}