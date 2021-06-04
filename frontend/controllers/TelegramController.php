<?php


namespace frontend\controllers;

use common\models\TelegramLastUpdate;
use common\models\TelegramToken;
use frontend\components\helpers\TelegramHelper;
use Yii;
use yii\web\Controller;
use aki\telegram\base\Command;

/* @var Yii::$app->telegram aki\telegram\Telegram */

class TelegramController extends Controller
{
    public function actionIndex()
    {

        $updateId = TelegramLastUpdate::find()->one();

        $result = Yii::$app->telegram->getUpdates(['offset' => $updateId->update_id + 1]);

        if ($result) foreach ($result['result'] as $item){

            $token = TelegramToken::findOne(['telegram_user_id' => $item['message']['from']['id']]);

            if ($text = $item['message']['text']) {

                switch ($text) {

                    case "/start":

                        if (!$token){

                            $token = TelegramHelper::generateToken($item['message']['chat']['id'], $item['message']['from']['id']);

                        }

                        if (isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_NOT_ACTIVE){

                            TelegramHelper::sendToken($item['message']['chat']['id'], $token->token);

                        }elseif(isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_ACTIVE){

                            TelegramHelper::sendMenu($item['message']['chat']['id']);

                        }

                        break;

                    case "/Баланс" :

                        if (isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_NOT_ACTIVE){

                            TelegramHelper::sendToken($item['message']['chat']['id'], $token->token);

                        }elseif(isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_ACTIVE){

                            TelegramHelper::sendBalance($item['message']['chat']['id']);

                        }

                        break;

                }

                if (!$updateId or $updateId->update_id <= $item['update_id']) {

                    if (!$updateId) $updateId = new TelegramLastUpdate();

                    $updateId->update_id = $item['update_id'];

                    $updateId->save();

                }

            }

        }

    }
}