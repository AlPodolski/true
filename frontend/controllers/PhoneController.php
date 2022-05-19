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
        $city_id = \Yii::$app->request->post('city_id');

        $time = time() - (1800);

        $phone = PhonesAdvert::find()
            ->where(['<', 'last_view' , $time])
            //->andWhere(['<=' , 'price', $price + 1100])
            //->andWhere(['>=' , 'price', $price - 1000])
            ->andWhere(['city_id' => $city_id])
            ->andWhere(['status' => PhonesAdvert::PUBLICATION_STATUS])
            ->orderBy('view DESC')
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