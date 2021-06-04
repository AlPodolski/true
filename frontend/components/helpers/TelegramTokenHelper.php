<?php


namespace frontend\components\helpers;


use common\models\TelegramToken;
use Yii;
use yii\base\ErrorException;

class TelegramTokenHelper
{
    public static function generateToken($telegram_chat_id, $telegram_user_id)
    {
        $token = new TelegramToken();

        if (!$telegram_chat_id or !$telegram_user_id)
            throw new ErrorException('Не переданы параметры $telegram_chat_id ='.$telegram_chat_id .' $telegram_user_id =' .$telegram_user_id);

        $token->telegram_user_id = $telegram_user_id;
        $token->telegram_chat_id = $telegram_chat_id;

        $token->token = \strtolower(\rand(100, 999).'-'.\rand(100, 999)
            .'-'.\rand(100, 999).'-'.\rand(100, 999));

        if ($token->validate() and $token->save()) return $token;

        else self::generateToken($telegram_chat_id, $telegram_user_id);

    }

}