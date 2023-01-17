<?php

namespace backend\controllers;

use frontend\modules\user\models\Posts;
use yii\web\Controller;

class PhoneController extends Controller
{

    public function actionEdit()
    {
        return $this->render('index');
    }
    public function actionUpdate()
    {

        $phone = \Yii::$app->request->post('phone');
        $userId = \Yii::$app->request->post('user_id');

        Posts::updateAll(['phone' => $phone], ['user_id' => $userId]);
    }
}