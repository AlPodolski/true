<?php

namespace frontend\controllers;
use yii\web\Controller;

class AuthController extends Controller
{

    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) return 'guest';
        return $this->redirect('/cabinet');
    }
}