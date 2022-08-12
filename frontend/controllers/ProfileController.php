<?php

namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public function actionIndex($city, $id)
    {

        $user = User::find()->where(['id' => $id])->with('review')->one();

        if (!$user) throw new NotFoundHttpException();

        return $this->render('index', compact('user') );
    }
}