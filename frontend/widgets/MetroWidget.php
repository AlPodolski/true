<?php


namespace frontend\widgets;

use common\models\City;
use common\models\Rayon;
use frontend\models\Metro;
use Yii;
use yii\base\Widget;

class MetroWidget extends Widget
{
    public function run()
    {

        if (isset(Yii::$app->requestedParams)
            and $city = City::getCity(Yii::$app->requestedParams['city'])
            and $metro = Metro::getMetro($city['id'])
        ) {

            return $this->render('metro', ['metro' => $metro]);

        }

        return false;
    }

    public static function checkExistMetro()
    {
        if (isset(Yii::$app->requestedParams['city'])
            and $city = City::getCity(Yii::$app->requestedParams['city'])
            and Metro::getMetro($city['id'])
        ) {

            return true;

        }

        return false;
    }

    public static function checkExistRayon()
    {
        if (isset(Yii::$app->requestedParams['city'])
            and $city = City::getCity(Yii::$app->requestedParams['city'])
            and Rayon::getAll($city['id'])
        ) {

            return true;

        }

        return false;
    }

}