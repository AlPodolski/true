<?php

namespace frontend\widgets;

use common\models\City;
use common\models\HairColor;
use common\models\National;
use common\models\Place;
use common\models\Rayon;
use frontend\models\Metro;
use yii\base\Widget;

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

        return $this->render('mega-menu', [
            'hairColorList' => $hairColorList,
            'nationalList' => $nationalList,
            'placeList' => $placeList,
            'metro' => $metro,
            'rayon' => $rayon,
        ]);
    }

}