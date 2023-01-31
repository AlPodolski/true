<?php


namespace common\components\service\notify;

use common\components\helpers\TelegramHelper;
use common\models\TelegramToken;
use common\models\User;
use Yii;

class Notify
{
    public static function send($text, $to, $subject = false)
    {
        $user = User::findOne($to);

        if ($user->notify == User::NOTIFY_ALLOWED) {

            if ($telegramToken = TelegramToken::findOne([
                'user_id' => $to, 'token_status' => TelegramToken::TOKEN_STATUS_ACTIVE
            ])) {
                TelegramHelper::sendMessage($telegramToken->telegram_chat_id, $text);
            }

            elseif ($user->email) {

                Yii::$app->mailer->compose()
                    ->setFrom('info@sex-trust.com')
                    ->setTo($user->email)
                    ->setSubject($subject)
                    ->setTextBody($text)
                    ->setHtmlBody('<p>' . $text . '</p>')
                    ->send();

            }

        }
    }
}