<?php

namespace frontend\controllers;

use common\models\PhoneAdvertViewStat;
use common\models\PhonesAdvert;
use common\models\Pol;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use yii\web\Controller;
use Yii;

class PhoneController extends Controller
{


    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex($city)
    {

        $price = Yii::$app->request->post('price');
        $city_id = Yii::$app->request->post('city_id');
        $postId = Yii::$app->request->post('id');
        $rayon = Yii::$app->request->post('rayon');
        $age = Yii::$app->request->post('age');

        $post = Posts::find()->where(['id' => $postId])->cache(3600)->one();

        if ($post){

            if ($post->fake) {

                ViewCountHelper::addView($post->id , Yii::$app->params['redis_view_phone_count_key']);
                return $post->phone;

            }else{

                if ($price <= 3000){
                    $priceRange = array('min' => $price - 500, 'max' => $price + 500);
                }else{
                    $priceRange = array('min' => $price - 1000, 'max' => $price + 1000);
                }

                $data = Posts::find()
                    ->where(['city_id' => $city_id])
                    ->andWhere(['<=', 'price', $priceRange['max']])
                    ->andWhere(['>=', 'price', $priceRange['min']])
                    ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                    ->andWhere(['fake' => Posts::POST_REAL])
                    ->andWhere(['>', 'advert_phone_view_count', 0])
                    ->andWhere(['<', 'last_phone_view_at', time() - 1300])
                    ->andWhere(['<>', 'user_id', 240])
                    ->orderBy(['last_phone_view_at' => SORT_ASC])
                    ->one();

                if ($data) {

                    $data->last_phone_view_at = time();
                    $data->advert_phone_view_count = $data->advert_phone_view_count - 1;

                    $data->save();

                    ViewCountHelper::addView($data->id , Yii::$app->params['redis_view_phone_count_key']);

                    return $data->phone;

                }else{

                    ViewCountHelper::addView($post->id , Yii::$app->params['redis_view_phone_count_key']);
                    return $post->phone;

                }

            }

        }

        return false;

    }
}