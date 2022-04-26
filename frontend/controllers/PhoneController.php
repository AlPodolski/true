<?php

namespace frontend\controllers;

use common\models\PhonesAdvert;
use frontend\modules\user\models\Posts;
use yii\web\Controller;

class PhoneController extends Controller
{
    public function actionIndex($city)
    {

        $price = \Yii::$app->request->post('price');

        $time = time() - (3 * 3600);

        $phone = PhonesAdvert::find()
            ->where(['<', 'last_view' , $time])
            ->andWhere(['>=' , 'price', $price - 800])
            ->andWhere(['<=' , 'price', $price + 500])
            ->one();

        if ($phone){

            $phone->view = $phone->view + 1;
            $phone->last_view = time();

            $phone->save();

            return $phone->phone;

        }else{

            $post = Posts::findOne(\Yii::$app->request->post('id'));

            return $post->phone;

        }

    }
}