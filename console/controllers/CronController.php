<?php

namespace console\controllers;

use common\components\helpers\TelegramChanelHelper;
use common\jobs\SendPostToTelegramJob;
use common\models\Phone;
use common\models\PhoneReview;
use common\models\Pol;
use common\models\Queue;
use common\models\SendPostToTelegram;
use frontend\models\Files;
use frontend\models\UserMetro;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\TopAnketBlock;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserRayon;
use frontend\modules\user\models\UserService;
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

        return true;

        $posts = Posts::find()
            ->where(['fake' => Posts::POST_FAKE])
            ->andWhere(['<>', 'user_id', 240])
            ->all();

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
            ->andWhere(['pol_id' => Pol::WOMAN_POL])
            ->orderBy('RAND()')
            ->limit(5)
            ->all();

        foreach ($posts as $post){

            $jobsCount = Queue::find()->where(['channel' => 'default'])->count() + 1;

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

            $post->updated_at = time() - rand(0, 3600);

            $post->save();

        }

    }

    public function actionView()
    {
        $posts = Posts::find()
            ->where(['fake' => Posts::POST_REAL])
            ->andWhere(['<', 'advert_phone_view_count', 5])
            ->all();

        foreach ($posts as $post){

            $post->advert_phone_view_count = 20;
            $post->save();

        }
    }

    public function actionDeleteOldPost()
    {

        $payTime = time() - (3600 * 24 *30);

        $webPath = Yii::getAlias('@frontend').'/web';

        $posts = Posts::find()
            ->where(['fake' => Posts::POST_REAL])
            ->with('files')
            ->andWhere(['<', 'pay_time', $payTime])
            ->limit(3000)
            ->all();

        foreach ($posts as $post){

            if ($post['files']){

                foreach ($post['files'] as $file){

                    foreach (Yii::$app->components['imageCache']['sizes'] as $key => $value){

                        $thumbPath = str_replace('uploads', 'thumbs', $webPath.$file->file);

                        $thumbPathWebp = str_replace('.jpg', '_'.$key.'.webp', $thumbPath);

                        $thumbPathJgp = str_replace('.jpg', '_'.$key.'.jpg', $thumbPath);

                        if (is_file($thumbPathWebp)) {

                            unlink($thumbPathWebp);

                        }

                        if (is_file($thumbPathJgp)) {

                            unlink($thumbPathJgp);

                        }

                    }

                    if (is_file($webPath.$file->file)){

                        unlink($webPath.$file->file);

                    }

                    $file->delete();

                }

            }

            if ($post->video and is_file($webPath.$post->video)){

                unlink($webPath.$post->video);

            }

            UserRayon::deleteAll(['post_id' => $post['id']]);
            UserMetro::deleteAll(['post_id' => $post['id']]);
            UserHairColor::deleteAll(['post_id' => $post['id']]);
            UserIntimHair::deleteAll(['post_id' => $post['id']]);
            UserNational::deleteAll(['post_id' => $post['id']]);
            UserPLace::deleteAll(['post_id' => $post['id']]);
            UserService::deleteAll(['post_id' => $post['id']]);

            Yii::$app->cache->delete('post_cache_'.$post->id.'_'.$post->city_id);

            $post->delete();

        }
    }

}