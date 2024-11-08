<?php

namespace backend\controllers;

use common\models\Pol;
use backend\models\IpPhoneCount;
use frontend\modules\user\models\Posts;
use yii\web\Controller;

class PhoneController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionEdit()
    {
        return $this->render('index');
    }
    public function actionUpdate()
    {

        $phone = \Yii::$app->request->post('phone');
        $userId = \Yii::$app->request->post('user_id');

        $phone = preg_replace('/[^0-9]/', '', $phone);

        Posts::updateAll(['phone' => $phone], ['user_id' => $userId]);
    }

    public function actionGet()
    {

        $date = date('d-m-Y', time());

        if ($count = IpPhoneCount::find()->where(['date' => $date])->one()){

            $count->count = $count->count + 1;

            $count->save();

        }else{

            $count = new IpPhoneCount();

            $count->count = 1;
            $count->date = $date;

            $count->save();

        }

        $city_id = \Yii::$app->request->post('city_id');

        $data = Posts::find()
            ->where(['city_id' => $city_id])
            ->andWhere(['pol_id' => Pol::WOMAN_POL])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['fake' => Posts::POST_REAL])
            ->andWhere(['<>', 'user_id', 240])
            ->orderBy(['last_phone_view_at' => SORT_ASC])
            ->one();

        if ($data){

            $data->last_phone_view_at = time() - 900;

            $data->save();

            return $data->phone;

        }
    }
}