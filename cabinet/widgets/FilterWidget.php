<?php


namespace cabinet\widgets;

use common\models\City;
use common\models\HairColor;
use common\models\IntimHair;
use common\models\National;
use common\models\Rayon;
use common\models\Service;
use cabinet\models\Metro;
use common\models\Place;
use Yii;
use yii\base\Widget;

class FilterWidget extends Widget
{

    public $dataGet;

    public function run()
    {

        $metro = false;
        $rayon = false;

        if (isset(Yii::$app->controller->actionParams['city'])

            and $city = City::getCity(Yii::$app->controller->actionParams['city'])){

            $metro = Metro::getMetro($city['id']);
            $rayon = Rayon::getAll($city['id']);

        }

        $national = National::getAll();

        return $this->render('filter', [
            'metro' => $metro,
            'rayon' => $rayon,
            'national' => $national,
            'dataGet' => $this->dataGet,
        ]);
    }
}