<?php

namespace frontend\modules\chat\components\helpers;

use frontend\modules\chat\models\Message;
use frontend\modules\chat\models\relation\UserDialog;
use yii\helpers\ArrayHelper;

class GetDialogsHelper
{
    public static function getDialogs($user_id){

        return $dialogList = UserDialog::find()->where(['user_id' => $user_id])->with('companion')->with('lastMessage')->all();

    }

    public static function getDialog($dialog_id){

        return $dialogList = UserDialog::find()->where(['dialog_id' => $dialog_id])->with('message')->asArray()->one();

    }

    public static function getCompanion($user_id, $chat_id){

        return $dialogList = UserDialog::find()->where(['dialog_id' => $chat_id])
            ->andWhere(['user_id' => $user_id])->asArray()->one();

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

    public static function serRead($chat_id, $user_id){

        Message::updateAll(['status' => 1], [ 'and',  ['chat_id' => $chat_id] , ['=', 'to' ,$user_id ]]);

    }

}