<?php

namespace console\controllers;

use common\components\service\notify\Notify;
use common\jobs\SendMail;
use common\jobs\SendPostToTelegramJob;
use common\models\History;
use common\models\Queue;
use common\models\Spisaniya;
use frontend\modules\user\models\Posts;
use Yii;

class PayController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $posts = Posts::find()
            ->where(['<', 'pay_time', \time()])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['fake' => 1])
            ->with('tarif')
            ->all();

        $sum = 0;

        foreach ($posts as $post) {

            if ($post['tarif']['sum'] > 0) {

                if (Yii::$app->pay->pay($post['tarif']['sum'], $post['user_id'], History::POST_PUBLICATION, $post['id'])) {

                    $post->pay_time = \time() + 3600;

                    $sum = $sum + $post['tarif']['sum'];


                } else {

                    $post->status = Posts::POST_DONT_PUBLICATION_STATUS;

                }

                $post->save();

            }

        }

        if ($sum) Spisaniya::add($sum);

    }
}