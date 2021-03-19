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

    public function actionPay()
    {

        $model = new PayForm();

        if ($model->load(Yii::$app->request->post())){

            $model->user = Yii::$app->user->id;

            $model->public_key = Yii::$app->params['qiwi_public_key'];

            if ($model->validate()) return $this->redirect($model->pay());

        }

        return $this->render('index', [
            'model' => $model
        ]);

    }
}