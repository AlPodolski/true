<?php


namespace frontend\widgets;

use common\models\City;
use frontend\models\Metro;
use Yii;
use yii\base\Widget;

class MetroWidget extends Widget
{
    public function run()
    {

        if (isset(Yii::$app->controller->actionParams['city'])
            and $city = City::getCity(Yii::$app->controller->actionParams['city'])
            and $metro = Metro::find()->where(['city_id' => $city['id']])->asArray()->orderBy('value')->all()
        ) {

            return $this->render('metro', ['metro' => $metro]);

        }

        return false;
    }
}