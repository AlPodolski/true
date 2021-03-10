<?php


namespace frontend\modules\chat\widgets;

use frontend\modules\chat\components\helpers\GetDialogsHelper;
use yii\base\Widget;

class MessageListWidget extends Widget
{

    public $user_id;

    public function run()
    {

        $dialogs = GetDialogsHelper::getDialogs($this->user_id);

        return $this->render('dialog_list', [
            'dialogs' => $dialogs,
            'user_id' => $this->user_id,
        ]);
    }
}