<?php

namespace common\behaviors;

use yii\base\Behavior;
use Yii;

class isAuth extends Behavior
{
    public function events()
    {
        return [
            yii\web\Controller::EVENT_BEFORE_ACTION => 'checkAuth'
        ];
    }

    public function checkAuth(){

        if (Yii::$app->user->isGuest) {

            Yii::$app->session->setFlash('warning', 'Требуется авторизация');

             header("Location: /login");

             exit();

        }

    }
}