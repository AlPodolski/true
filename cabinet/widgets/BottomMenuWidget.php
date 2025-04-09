<?php

namespace cabinet\widgets;

use common\models\City;
use common\models\HairColor;
use common\models\National;
use common\models\Place;
use common\models\Rayon;
use common\models\Rost;
use common\models\Time;
use common\models\Ves;
use cabinet\models\Metro;
use yii\base\Widget;

class BottomMenuWidget extends Widget
{
    public $city;
    public $bottom_menu = false;

    public function run()
    {

        $cityInfo = City::findOne(['url' => $this->city]);

        $metro = Metro::getMetro($cityInfo['id']);
        $rayon = Rayon::getAll($cityInfo['id']);

        $hairColorList = HairColor::getAll();
        $nationalList = National::getAll();
        $placeList = Place::getPlace();
        $timeList = Time::getTime();
        $rostList = Rost::getData();
        $ves = Ves::getData();



        return $this->render('bottom-menu', [
            'hairColorList' => $hairColorList,
            'nationalList' => $nationalList,
            'placeList' => $placeList,
            'metro' => $metro,
            'rayon' => $rayon,
            'timeList' => $timeList,
            'rostList' => $rostList,
            'ves' => $ves,
        ]);
    }
}