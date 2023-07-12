<?php

namespace frontend\widgets;

use common\models\City;
use common\models\HairColor;
use common\models\National;
use common\models\Place;
use common\models\Rayon;
use common\models\Service;
use common\models\Time;
use common\models\Ves;
use frontend\models\Metro;
use Yii;
use yii\base\Widget;
use common\models\Rost;

class MegaMenuWidget extends Widget
{

    public $city;
    public $bottom_menu = false;

    public function run()
    {

        $cityInfo = City::getCity($this->city);

        $metro = Metro::getMetro($cityInfo['id']);
        $rayon = Rayon::getAll($cityInfo['id']);

        $hairColorList = HairColor::getAll();
        $nationalList = National::getAll();
        $placeList = Place::getPlace();
        $timeList = Time::getTime();
        $rostList = Rost::getData();
        $service = Service::getService();
        $ves = Ves::getData();

        if ($this->bottom_menu) return $this->render('bottom-menu' , [
            'hairColorList' => $hairColorList,
            'nationalList' => $nationalList,
            'placeList' => $placeList,
            'metro' => $metro,
            'rayon' => $rayon,
            'timeList' => $timeList,
            'rostList' => $rostList,
            'ves' => $ves,
        ]);

        return $this->render('mega-menu', [
            'hairColorList' => $hairColorList,
            'nationalList' => $nationalList,
            'placeList' => $placeList,
            'metro' => $metro,
            'service' => $service,
            'rayon' => $rayon,
            'timeList' => $timeList,
            'rostList' => $rostList,
            'ves' => $ves,
        ]);
    }

}