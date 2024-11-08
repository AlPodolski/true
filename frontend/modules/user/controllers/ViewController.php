<?php


namespace frontend\modules\user\controllers;

use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\forms\BuyViewForm;
use Yii;
use frontend\modules\user\controllers\CabinetBeforeController as Controller;
use yii\filters\VerbFilter;

class ViewController extends Controller
{

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionViewPhone()
    {
        $id = Yii::$app->request->post('id');

        ViewCountHelper::addView($id, Yii::$app->params['redis_view_phone_count_key']);

        return true;
    }

    public function actionBuyView($city)
    {

        $model = new BuyViewForm();

        if ($model->load(Yii::$app->request->post()) and $model->save()){

            Yii::$app->session->setFlash('success', 'Показы куплены');

        }else{

            Yii::$app->session->setFlash('warning', 'Ошибка');

        }

        return $this->redirect(Yii::$app->request->referrer);
    }

}