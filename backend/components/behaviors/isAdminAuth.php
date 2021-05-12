<?php

namespace backend\components\behaviors;

use common\models\User;
use yii\base\Behavior;
use Yii;

class isAdminAuth extends Behavior
{
    public function events()
    {
        return [
            yii\web\Controller::EVENT_BEFORE_ACTION => 'checkAuth'
        ];
    }

    public function checkAuth(){

        if (Yii::$app->user->isGuest or Yii::$app->user->identity['role'] != User::ADMIN_ROLE) {

            Yii::$app->user->logout();

            Yii::$app->session->setFlash('warning', 'Требуется авториция');

            Yii::$app->response->redirect(['/auth/login'], 301, false);

        }

    }
}