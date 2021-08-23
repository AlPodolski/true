<?php

namespace console\controllers;

use common\models\Phone;
use common\models\PhoneReview;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\TopAnketBlock;
use Yii;
use yii\console\Controller;

class CronController extends Controller
{
    public function actionUp ()
    {
        $posts = Posts::find()
            ->with('avatar')
            ->where(['user_id' => 22038])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->limit(1)
            ->orderBy('RAND()')
            ->all();

        foreach ($posts as $post){

            $upAnketModel = new TopAnketBlock();

            $upAnketModel->post_id = $post['id'];
            $upAnketModel->city_id = 1;
            $upAnketModel->valid_to = \time() + 3600;

            $upAnketModel->save();

        }
    }

    public function actionCountPhoneRating()
    {
        $posts = Posts::find()->where(['fake' => 0, 'status' => 1])->groupBy('phone')->all();

        foreach ($posts as $post){

            if (!$phonePostId = Phone::find()->where(['phone' => $post['phone']])->one()){

                $phonePostId = new Phone();

                $phonePostId->phone = $post['phone'];

                $phonePostId->save();

            }

            $phoneReview = PhoneReview::find()->where(['phone_id' => $phonePostId->id])->with('marc')->all();

            if ($phoneReview){

                $sum = 0;

                foreach ($phoneReview as $item){

                    $sum = $sum + $item['marc']['marc'];

                }

                if ($sum <= Yii::$app->params['phone_min_rating_for_publication']){

                    Posts::updateAll(['status' => 0], ['phone' => $post['phone'], 'fake' => 0]);

                }

            }

        }

    }
    
}