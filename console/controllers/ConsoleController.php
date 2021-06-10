<?php


namespace console\controllers;

use frontend\modules\chat\components\helpers\GetDialogsHelper;
use frontend\modules\chat\models\forms\SendMessageForm;
use frontend\modules\chat\models\Message;
use frontend\modules\chat\models\relation\UserDialog;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use Yii;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionCountRating()
    {

        $posts = Posts::find()->with('selphiCount', 'nacionalnost', 'cvet',
            'strizhka', 'osobenost', 'serviceDesc', 'service')->all();

        foreach ($posts as $post){

            $tempData = $this->countCtr($post['id']);

            if ($tempData['phoneViewCtr'] > 0 and $tempData['pageViewCtr'] > 0) {

                $data = (($tempData['pageViewCtr'] * 2) + ($tempData['phoneViewCtr'] * 6));

            }

            $postRating = \frontend\helpers\PostRatingHelper::getPostRating($post['id']);

            if ($postRating){

                $data = $data + $postRating['total_rating'];

            }

            if ($post['service']){

                $data = $data + 1;

            }
            if ($post['serviceDesc']){

                $data = $data + 1;

            }
            if ($post['osobenost']){

                $data = $data + 1;

            }
            if ($post['strizhka']){

                $data = $data + 1;

            }
            if ($post['cvet']){

                $data = $data + 1;

            }
            if ($post['nacionalnost']){

                $data = $data + 1;

            }
           if ($post['selphiCount']){

                $data = $data + 1;

            }

            if ($post['check_photo_status']){

                $data = $data + 2;

            }

            if ($post['video']){

                $data = $data + 1;

            }

            if ($post['age']){

                $data = $data + 1;

            }

            if ($post['rost']){

                $data = $data + 1;

            }

            if ($post['breast']){

                $data = $data + 1;

            }

            if ($post['ves']){

                $data = $data + 1;

            }

            $raiting = (int) (10000 / $data);

            if ($raiting) {

                $post->sort = $raiting;

                $post->save();

            }

        }

    }

    private function countCtr($id){

        $showPostCount = ViewCountHelper::countView($id, Yii::$app->params['redis_post_listing_view_count_key']);

        $phoneViewCount = ViewCountHelper::countView($id, Yii::$app->params['redis_view_phone_count_key']);

        $singlePageViewCount = ViewCountHelper::countView($id, Yii::$app->params['redis_post_single_view_count_key']);

        if ($showPostCount > 0 and $singlePageViewCount > 0) $pageViewCtr = $showPostCount / $singlePageViewCount;
        else $pageViewCtr = 0;

        if ($singlePageViewCount > 0 and $phoneViewCount > 0) $phoneViewCtr = $showPostCount / $phoneViewCount;
        else $phoneViewCtr = 0;

        return [
            'phoneViewCtr' => $phoneViewCtr,
            'pageViewCtr' => $pageViewCtr,
        ];

    }

    public function actionIndex()
    {
        $messages = Message::find()->where(['status' => 0])
            ->andWhere(['<', 'created_at', (\time() - 3600 )])
            ->select('chat_id , from, message')->asArray()->all();

        $userReply = [];

        foreach ($messages as $message){

            $userInfo = UserDialog::find()->where(['dialog_id' => $message['chat_id']])->andWhere(['<>', 'user_id', $message['from']])
                ->asArray()->with('user')->one();



            if ($userInfo['user']['fake'] == 0 and !\in_array($message['from'], $userReply) ){

                $session_id = \md5($message['from'].$userInfo['id']);
                $text = $message['message'];

                $data = array(
                    'session_id' => $session_id,
                    'text'       => $text,
                );

                if ($curl = \curl_init()) {
                    \curl_setopt($curl, CURLOPT_URL, 'https://gdialog.pr-13.com/message');
                    \curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    \curl_setopt($curl, CURLOPT_POST, true);
                    \curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $out = \curl_exec($curl);
                    \curl_close($curl);

                    if (strlen($out) < 500) {

                        $userReply[] = $message['from'];

                        $answerText = $out;

                        GetDialogsHelper::serRead($message['chat_id'], $userInfo['user']['id']);

                        $this->sendMessage($userInfo['user']['id'] , $message['from'], $message['chat_id'] , $answerText );

                    }

                }

            }

        }

    }

    public function sendMessage($from, $to , $chat_id = false, $text = false)
    {

        $model = new SendMessageForm();

        $model->from_id = $from;
        $model->created_at = \time();
        $model->to = $to;
        if ($chat_id) $model->chat_id = $chat_id;
        $model->text = $text;

        $model->save();
    }

}