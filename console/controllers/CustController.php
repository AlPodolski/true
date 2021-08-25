<?php


namespace console\controllers;

use backend\models\Posts;
use common\models\City;
use common\models\Phone;
use frontend\modules\user\models\PostSites;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;
use common\models\User;

class CustController extends Controller
{
    public function actionIndex()
    {
        $city = City::find()->all();

        foreach ($city as $item){

            echo $item['value'].' - '.Posts::find()->where(['city_id' => $item['id']])->count().\PHP_EOL;

        }

    }
}