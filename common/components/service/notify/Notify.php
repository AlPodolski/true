<?php


namespace common\components\service\notify;


use common\components\helpers\TelegramHelper;
use common\models\TelegramToken;
use common\models\User;

class Notify
{
    public static function send($text, $to)
    {
        $user = User::findOne($to);

        if ($user->notify == User::NOTIFY_ALLOWED and
            $telegramToken = TelegramToken::findOne([
                'user_id' => $to, 'token_status' => TelegramToken::TOKEN_STATUS_ACTIVE
            ])){

            TelegramHelper::sendMessage($telegramToken->telegram_chat_id, $text);

        }
    }
}