<?php


namespace frontend\controllers;

use common\models\TelegramLastUpdate;
use common\models\TelegramToken;
use frontend\components\helpers\TelegramHelper;
use Yii;
use yii\web\Controller;
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

        $telegram = new Api('1780291875:AAEsHj_Bgy50QiX6QWK_opQ7wHfZD9Pka4E');

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
}