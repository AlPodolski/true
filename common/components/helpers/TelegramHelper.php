<?php


namespace common\components\helpers;


use common\models\TelegramToken;
use Yii;
use yii\base\ErrorException;

class TelegramHelper
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

    public static function sendMessage($chat_id, $text)
    {

        try {
            Yii::$app->telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => $text,
            ]);
        }catch (\Exception $message){
            echo $message->getMessage();
        }

    }

    public static function sendMenu($chat_id)
    {
        $keyboard = [
            'keyboard'=>[
                [['text'=>'/Баланс']] // Первый ряд кнопок
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];

        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Что будем делать? ',
            'reply_markup' => \json_encode($keyboard)
        ]);
    }

    public static function sendToken($chat_id, $token)
    {
        Yii::$app->telegram->sendPhoto([
            'chat_id' => $chat_id,
            'photo' => 'https://tele.sex-true.com/img/telegram-form-example.png',
        ]);

        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Введите код в форму на сайте : '.$token,
        ]);
    }

    public static function sendBalance($chat_id)
    {

        $balance = TelegramToken::find()->where(['telegram_chat_id' => $chat_id])->with('user')->one();

        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Баланс : '.$balance['user']['cash'] .' руб.',
        ]);
    }

}