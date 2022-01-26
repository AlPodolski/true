<?php

namespace frontend\widgets;

use common\models\City;
use common\models\HairColor;
use common\models\National;
use common\models\Place;
use common\models\Rayon;
use common\models\Time;
use frontend\models\Metro;
use Yii;
use yii\base\Widget;
use common\models\Rost;

class MegaMenuWidget extends Widget
{

    public $city;

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

        return $this->render('mega-menu', [
            'hairColorList' => $hairColorList,
            'nationalList' => $nationalList,
            'placeList' => $placeList,
            'metro' => $metro,
            'rayon' => $rayon,
            'timeList' => $timeList,
            'rostList' => $rostList,
        ]);
    }

}