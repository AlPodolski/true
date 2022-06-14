<?php

namespace frontend\controllers;

use common\models\PhonesAdvert;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use yii\web\Controller;
use Yii;

class PhoneController extends Controller
{
    public function actionIndex($city)
    {

        $price = Yii::$app->request->post('price');
        $city_id = Yii::$app->request->post('city_id');
        $postId = Yii::$app->request->post('id');
        $national = Yii::$app->request->post('national');
        $rayon = Yii::$app->request->post('rayon');
        $age = Yii::$app->request->post('age');

        if ($post = Posts::findOne($postId)){

            if ($post->fake) {

                ViewCountHelper::addView($post->id , Yii::$app->params['redis_view_phone_count_key']);

                return $post->phone;

            }else{

                $phone = PhonesAdvert::find()
                    ->where(['status' => PhonesAdvert::PUBLICATION_STATUS])
                    ->andWhere(['<=' , 'price', $price + 100])
                    ->andWhere(['>=' , 'price', $price - 1200])
                    ->andWhere(['city_id' => $city_id])
                    ->orderBy('view DESC');

                if ($age) {

                    $phone = $phone->andWhere(['<=' , 'age', $age + 5])
                                    ->andWhere(['>=' , 'age', $age - 5]);

                }
                if ($rayon) $phone = $phone->andWhere(['rayon_id' => $rayon]);

                $phone = $phone->one();

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

        return false;

    }
}