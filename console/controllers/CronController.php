<?php

namespace console\controllers;

use common\components\helpers\TelegramChanelHelper;
use common\jobs\SendPostToTelegramJob;
use common\models\Phone;
use common\models\PhoneReview;
use common\models\Queue;
use common\models\SendPostToTelegram;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\TopAnketBlock;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

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
        $posts = Posts::find()
            ->select('id')
            ->where(['city_id' => 1])
            ->orderBy('RAND()')
            ->limit(8)
            ->all();

        foreach ($posts as $post){

            $jobsCount = Queue::find()->count() + 1;

            $id = Yii::$app->queue->delay($jobsCount * 60)->push(new SendPostToTelegramJob([
                'postId' => $post->id,
            ]));

            if ($id){

                $sendPostToTelegram = new SendPostToTelegram();

                $sendPostToTelegram->post_id = $post->id;
                $sendPostToTelegram->created_at = time();
                $sendPostToTelegram->job_id = $id;

                $sendPostToTelegram->save();

            }



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

    public function actionUpdateTime()
    {

        $posts = Posts::find()->where(['fake' => Posts::POST_FAKE])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->limit(100)->orderBy('RAND()')->all();

        foreach ($posts as $post){

            $post->updated_at = time() - rand(0, 7200);

            $post->save();

        }

    }

}