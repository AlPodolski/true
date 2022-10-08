<?php

namespace frontend\controllers;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) return 'guest';
        return $this->redirect('/cabinet');
    }
}