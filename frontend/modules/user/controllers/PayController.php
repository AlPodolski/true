<?php


namespace frontend\modules\user\controllers;
use frontend\modules\user\models\forms\PayForm;
use Yii;
use yii\web\Controller;

class PayController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionPay($city)
    {

        $model = new PayForm();

        if ($model->load(Yii::$app->request->post())){

            $model->user = Yii::$app->user->id;
            $model->city = $city;

            if ($model->validate()) return $this->redirect($model->pay()['payUrl']);

        }

        return $this->render('index', [
            'model' => $model
        ]);

    }
}