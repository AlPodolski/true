<?php


namespace frontend\widgets;

use common\models\City;
use Yii;
use yii\base\Widget;

class CurrentCity extends Widget
{
    public function run()
    {

        if (isset(Yii::$app->controller->actionParams['city']) and $city = City::getCity(Yii::$app->controller->actionParams['city'])) {

            return $city['city'];

        }

        return false;

    }
}