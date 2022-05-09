<?php

namespace console\controllers;

use common\components\helpers\TelegramChanelHelper;
use common\models\Phone;
use common\models\PhoneReview;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\TopAnketBlock;
use Yii;
use yii\console\Controller;

class CronController extends Controller
{



    public function actionUp()
    {
        return true;
    }

    public function actionSort()
    {
        $posts = Posts::find()->where(['fake' => Posts::POST_FAKE])->all();

        foreach ($posts as $post){

            $post->sort = rand(0, 1000);

            $post->save();

        }

    }

    public function actionSendPostToTelegramChanel()
    {
        $posts = Posts::find()->with('gallery', 'avatar', 'metro')
            ->where(['city_id' => 1])->orderBy('RAND()')->limit(8)->all();

        foreach ($posts as $post){

            TelegramChanelHelper::sendPostToChanel($post);

            sleep(61);

        }



    }

    public function actionCountPhoneRating()
    {
        $posts = Posts::find()->where(['fake' => 0, 'status' => 1])->groupBy('phone')->all();

        foreach ($posts as $post) {

            if (!$phonePostId = Phone::find()->where(['phone' => $post['phone']])->one()) {

                $phonePostId = new Phone();

                $phonePostId->phone = $post['phone'];

                $phonePostId->save();

            }

            $phoneReview = PhoneReview::find()->where(['phone_id' => $phonePostId->id])->with('marc')->all();

            if ($phoneReview) {

                $sum = 0;

                foreach ($phoneReview as $item) {

                    $sum = $sum + $item['marc']['marc'];

                }

                if ($sum <= Yii::$app->params['phone_min_rating_for_publication']) {

                    Posts::updateAll(['status' => Posts::POST_DONT_PUBLICATION_STATUS], ['phone' => $post['phone'], 'fake' => 0]);

                }

            }

        }

    }

}