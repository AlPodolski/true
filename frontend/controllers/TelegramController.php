<?php


namespace frontend\controllers;

use common\models\TelegramLastUpdate;
use common\models\TelegramToken;
use frontend\components\helpers\TelegramTokenHelper;
use Yii;
use yii\web\Controller;
use aki\telegram\base\Command;

/* @var Yii::$app->telegram aki\telegram\Telegram */

class TelegramController extends Controller
{
    public function actionIndex()
    {

        $updateId = TelegramLastUpdate::find()->one();

        $result = Yii::$app->telegram->getUpdates(['offset' => $updateId->update_id ]);

        if ($result) foreach ($result['result'] as $item){

            $token = TelegramToken::findOne(['telegram_user_id' => $item['message']['from']['id']]);

            if ($text = $item['message']['text']) {

                switch ($text) {

                    case "/start":

                        if (!$token){

                            $token = TelegramTokenHelper::generateToken($item['message']['chat']['id'], $item['message']['from']['id']);

                        }

                        if (isset($token->token_status) and $token->token_status == TelegramToken::TOKEN_STATUS_NOT_ACTIVE){

                            Yii::$app->telegram->sendPhoto([
                                'chat_id' => $item['message']['chat']['id'],
                                'photo' => 'https://tele.sex-true.com/img/telegram-form-example.png',
                            ]);

                            Yii::$app->telegram->sendMessage([
                                'chat_id' => $item['message']['chat']['id'],
                                'text' => 'Введите код в форму на сайте : '.$token->token,
                            ]);

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

        \dd($result);

    }
}