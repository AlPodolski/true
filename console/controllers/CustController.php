<?php


namespace console\controllers;

use backend\models\Posts;
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
        $phones = Posts::find()->all();

        foreach ($phones as $phone){

            $newPhone = new Phone();

            $newPhone->phone = $phone->phone = preg_replace('/[^0-9]/', '', $phone['phone']);

            $phone->save();

            $newPhone->save();

        }

    }
}