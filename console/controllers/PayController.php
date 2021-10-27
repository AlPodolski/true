<?php

namespace console\controllers;

use common\components\service\history\HistoryService;
use common\models\History;
use frontend\modules\user\models\Posts;
use Yii;

class PayController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $posts = Posts::find()
            ->where(['<','pay_time', \time()])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['fake' => 1])
            ->all();

        foreach ($posts as $post){

            if (!$firstUserPost = Yii::$app->cache->get(Yii::$app->params['user_first_post_cache_key'].'_'.$post['user_id'])){

                $firstUserPost = $post['id'];

                $post->pay_time = \time() + 3600;

                $post->save();

                Yii::$app->cache->set(Yii::$app->params['user_first_post_cache_key'].'_'.$post['user_id'], $post['id'],3600);

            }

            if ($firstUserPost != $post['id']){

                if (Yii::$app->pay->pay(Yii::$app->params['hour_pay_sum'], $post['user_id'], History::POST_PUBLICATION, $post['id'])){

                    $post->pay_time = \time() + 3600;


                }else{

                    $post->status = Posts::POST_DONT_PUBLICATION_STATUS;

                }

                $post->save();

            }

        }
    }
}