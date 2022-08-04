<?php

namespace console\controllers;

use common\components\service\notify\Notify;
use common\jobs\SendMail;
use common\jobs\SendPostToTelegramJob;
use common\models\History;
use common\models\Queue;
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

        foreach ($posts as $post) {

            if ($post['tarif']['sum'] > 0) {

                if (Yii::$app->pay->pay($post['tarif']['sum'], $post['user_id'], History::POST_PUBLICATION, $post['id'])) {

                    $post->pay_time = \time() + 3600;


                } else {

                    $jobsCount = Queue::find()->where(['channel' => 'mail'])->count() + 1;

                    Yii::$app->queueMail->delay($jobsCount * 10)->push(new SendMail([
                        'text' => 'Анкета ' . $post->name . ' снята с публикации из за низкого баланса',
                        'to' => $post['user_id'],
                        'subject' => 'Остановка публикации',
                    ]));

                    $post->status = Posts::POST_DONT_PUBLICATION_STATUS;

                }

                $post->save();

            }

        }
    }
}