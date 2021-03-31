<?php


namespace frontend\modules\user\controllers;

use frontend\modules\user\helpers\ViewCountHelper;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class ViewController extends Controller
{

    public function actionViewPhone()
    {
        $id = Yii::$app->request->post('id');

        ViewCountHelper::addView($id, Yii::$app->params['redis_view_phone_count_key']);

        return true;
    }

}