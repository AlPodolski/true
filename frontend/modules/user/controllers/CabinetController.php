<?php

namespace frontend\modules\user\controllers;

use Yii;

class CabinetController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }


    public function actionIndex($city)
    {

        $user = Yii::$app->user->identity;

        return $this->render('index', [
            'user' => $user
        ]);
    }

}
