<?php


namespace frontend\controllers;

use common\jobs\SendMediaToTelegram;
use common\jobs\SendPostToTelegramJob;
use common\models\TelegramLastUpdate;
use common\models\TelegramToken;
use common\components\helpers\TelegramHelper;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Yii;
use frontend\controllers\BeforeController as Controller;
use aki\telegram\base\Command;
use Telegram\Bot\Api;

/* @var Yii::$app->telegram aki\telegram\Telegram */
class TelegramController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $updateId = TelegramLastUpdate::find()->one();

        $telegram = new Api(Yii::$app->params['telegram_token']);

        $result = $telegram->getWebhookUpdates();

        $token = TelegramToken::findOne(['telegram_user_id' => $result['message']['from']['id']]);

        if ($text = $result['message']['text']) {

            switch ($text) {

                case "/start":

                    if (!$token) {

                        $token = TelegramHelper::generateToken($result['message']['chat']['id'], $result['message']['from']['id']);

                    }

                    if (isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_NOT_ACTIVE) {

                        TelegramHelper::sendToken($result['message']['chat']['id'], $token->token);

                    } elseif (isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_ACTIVE) {

                        TelegramHelper::sendMenu($result['message']['chat']['id']);

                    }

                    break;

                case "/Баланс" :

                    if (isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_NOT_ACTIVE) {

                        TelegramHelper::sendToken($result['message']['chat']['id'], $token->token);

                    } elseif (isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_ACTIVE) {

                        TelegramHelper::sendBalance($result['message']['chat']['id']);

                    }

                    break;

            }

            if (!$updateId or $updateId->update_id <= $result['update_id']) {

                if (!$updateId) $updateId = new TelegramLastUpdate();

                $updateId->update_id = $result['update_id'];

                $updateId->save();

            }

        }

    }

    public function actionSend()
    {

        $key = Yii::$app->params['telegram_action_key'];

        $keyFromRequest = Yii::$app->request->post('key');

        if ($keyFromRequest != $key) throw new AccessDeniedException();

        $data = Yii::$app->request->post('data');

        $id = Yii::$app->queue->push(new SendMediaToTelegram([
            'data' => $data,
        ]));

        return $id;

    }

}