<?php


namespace frontend\widgets;

use common\models\City;
use common\models\National;
use common\models\Place;
use common\models\Rayon;
use common\models\Rost;
use common\models\Service;
use common\models\Time;
use common\models\Ves;
use Yii;
use yii\base\Widget;

class DataWidget extends Widget
{

    public $data;
    public $dataGet;
    public $city_id;

    public function run()
    {

        switch ($this->data) {
            case 'metro':
                return $this->render('data-metro');
            case 'rayon':
                $data = Rayon::find()->where(['city_id' => $this->city_id])->all();
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'cena':
                $data = array(
                    array('url' => 'do-1500', 'value' => 'До 1500 руб.'),
                    array('url' => 'ot-1500-do-2000', 'value' => 'От 1500 до 2000 руб.'),
                    array('url' => 'ot-2000-do-3000', 'value' => 'От 2000 до 3000 руб.'),
                    array('url' => 'ot-3000-do-6000', 'value' => 'От 3000 до 6000 руб.'),
                    array('url' => 'ot-6000', 'value' => 'От 6000 руб.'),
                );
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'vozrast':
                $data = array(
                    array('url' => '18-20', 'value' => 'От 18 до 20 лет'),
                    array('url' => '21-25', 'value' => 'От 21 до 25 лет'),
                    array('url' => '26-30', 'value' => 'От 26 до 30 лет'),
                    array('url' => '31-35', 'value' => 'От 31 до 35 лет'),
                    array('url' => '36-40', 'value' => 'От 36 до 40 лет'),
                    array('url' => '40-50', 'value' => 'От 40 до 50 лет'),
                    array('url' => '50-75', 'value' => 'От 50 до 75 лет'),
                );
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'nacionalnost':
                $data = National::find()->all();
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'mesto':
                $data = Place::find()->all();
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'usluga':
                $data = Service::find()->all();
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'vremya':
                $data = Time::find()->all();
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'rost':
                $data = Rost::getData();
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'ves':
                $data = Ves::getData();
                return $this->render('data-menu', [
                    'data' => $data,
                    'url' => $this->data
                ]);
            case 'filter':
                return $this->render('data-filter', ['dataGet' => $this->dataGet]);
            case 'city':

                $cityList = City::find()->where(['like', 'city', Yii::$app->request->get('val')])->all();

                return $this->render('data-city', ['cityList' => $cityList]);
        }

        return false;

    }
}