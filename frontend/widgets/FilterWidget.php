<?php


namespace frontend\widgets;

use common\models\City;
use common\models\HairColor;
use common\models\IntimHair;
use common\models\National;
use common\models\Rayon;
use common\models\Service;
use frontend\models\Metro;
use common\models\Place;
use Yii;
use yii\base\Widget;

class FilterWidget extends Widget
{
    public function run()
    {

        $metro = false;
        $rayon = false;

        if (isset(Yii::$app->controller->actionParams['city'])

            and $city = City::getCity(Yii::$app->controller->actionParams['city'])){

            $metro = Metro::getMetro($city['id']);
            $rayon = Rayon::getAll($city['id']);

        }

        $service = Service::getService();
        $place = Place::getPlace();
        $naci = National::getAll();
        $hair = HairColor::getAll();
        $intimHair = IntimHair::getAll();

        return $this->render('filter', [
            'metro' => $metro,
            'rayon' => $rayon,
            'service' => $service,
            'place' => $place,
            'naci' => $naci,
            'hair' => $hair,
            'intimHair' => $intimHair,
        ]);
    }
}