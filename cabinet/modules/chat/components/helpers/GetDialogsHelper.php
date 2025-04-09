<?php

namespace cabinet\modules\chat\components\helpers;

use cabinet\modules\chat\models\Message;
use cabinet\modules\chat\models\relation\UserDialog;
use yii\helpers\ArrayHelper;

class GetDialogsHelper
{
    public static function getDialogs($user_id){

        return $dialogList = UserDialog::find()->where(['user_id' => $user_id])->with('companion')->with('lastMessage')->all();

    }

    public static function getDialog($dialog_id){

        return $dialogList = UserDialog::find()->where(['dialog_id' => $dialog_id])->with('message')->one();

    }

    public static function getCompanion($user_id, $chat_id){

        return $dialogList = UserDialog::find()->where(['dialog_id' => $chat_id])
            ->andWhere(['user_id' => $user_id])->asArray()->one();

    }

    public static function getCountNotRead($chat_id, $from_id)
    {
        return Message::find()->where(['chat_id' => $chat_id, 'from' => $from_id, 'status' => 0])->count();
    }

    public static function getNotReadCount($user_id){

        return Message::find()->where(['status' => 0])
                ->andWhere(['<>' , 'from', $user_id])
                ->andWhere(['in', 'chat_id', ArrayHelper::getColumn(UserDialog::find()
                    ->where(['user_id' => $user_id])
                    ->select('dialog_id')
                    ->asArray()
                    ->all(), 'dialog_id') ])
                ->count();

    }

    public static function getUserNoteReadMessageCount($userId)
    {
        return Message::find()->where([ 'to' => $userId, 'status' => 0])->count();
    }

    public static function serRead($chat_id, $user_id){

        Message::updateAll(['status' => 1], [ 'and',  ['chat_id' => $chat_id] , ['=', 'to' ,$user_id ]]);

    }

}