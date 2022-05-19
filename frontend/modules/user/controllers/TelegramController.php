<?php


namespace frontend\modules\user\controllers;

use common\models\History;
use common\models\Queue;
use common\models\User;
use common\components\helpers\TelegramHelper;
use frontend\modules\user\models\forms\CheckTelegramForm;
use frontend\modules\user\models\Posts;
use Yii;
use frontend\controllers\BeforeController as Controller;
use yii\filters\VerbFilter;
use common\jobs\SendPostToTelegramJob;

class TelegramController extends Controller
{
    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'send-post' => ['post'],
                    'index' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex($city)
    {

        $user = User::find()->where(['id' => Yii::$app->user->id])->with('avatar')->one();

        $tokenForm = new CheckTelegramForm();

        $tokenForm->user_id = Yii::$app->user->id;

        if ($tokenForm->load(Yii::$app->request->post()) and $tokenForm->validate() and $token = $tokenForm->checkStatus()){

            TelegramHelper::sendMenu($token->telegram_chat_id);

            Yii::$app->session->setFlash('success', 'Телеграм подтвержден');

            return $this->redirect('/cabinet');

        }

        if ($tokenForm->hasErrors())  Yii::$app->session->setFlash('warning', $tokenForm->getFirstErrors());

        return $this->render('index', [
            'user' => $user,
            'tokenForm' => $tokenForm
        ]);
    }

    public function actionSendPost()
    {

        $user = Yii::$app->user->identity;

        if ($user['cash'] >= $cost = Yii::$app->params['publication_telegram_cost']){

            $id = Yii::$app->request->post('id');

            if ($post = Posts::findOne($id) and $post->user_id == Yii::$app->user->id){

                if (Yii::$app->pay->pay($cost, $post['user_id'], History::POST_PUBLICATION_TELEGRAM, $post['id'])) {

                    $jobsCount = Queue::find()->count() + 1;

                    $id = Yii::$app->queue->delay($jobsCount * 60)->push(new SendPostToTelegramJob([
                        'postId' => $post->id,
                    ]));

                    if ($id) return 'Добавлена в очередь';

                }

                return 'Ошибка';

            }

        }

        return 'Недостаточно средств';

    }

}