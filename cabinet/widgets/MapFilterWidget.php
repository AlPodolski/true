<?php

namespace cabinet\widgets;

use common\models\HairColor;
use common\models\IntimHair;
use common\models\National;
use common\models\Place;
use yii\base\Widget;

class MapFilterWidget extends Widget
{
    public function run()
    {

        $place = Place::getPlace();
        $naci = National::getAll();
        $hair = HairColor::getAll();
        $intimHair = IntimHair::getAll();

        return $this->render('filter-map', [
            'place' => $place,
            'naci' => $naci,
            'hair' => $hair,
            'intimHair' => $intimHair,
        ]);
    }
}