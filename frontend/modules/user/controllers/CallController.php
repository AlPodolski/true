<?php


namespace frontend\modules\user\controllers;

use common\models\RequestCall;
use Yii;
use yii\web\Controller;

class CallController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionIndex($city)
    {

        $requestCalls = RequestCall::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->asArray()
            ->orderBy('id DESC')
            ->all();

        return $this->render('index', [
            'requestCalls' => $requestCalls
        ]);
    }
}