<?php
/* @var $user array*/

namespace frontend\modules\chat\widgets;

use frontend\modules\chat\components\helpers\GetDialogsHelper;
use Yii;
use yii\base\Widget;

class DialogWidget extends Widget
{
    public $dialog_id;
    public $user;
    public $recepient = false;
    public $userTo;
    public $limitExist;

    public function run()
    {

        $dialog = GetDialogsHelper::getDialog($this->dialog_id);

        GetDialogsHelper::serRead($dialog['dialog_id'], Yii::$app->user->id);

        return $this->render('dialog', [
            'dialog' => $dialog,
            'dialog_id' => $dialog['dialog_id'],
            'user' => $this->user,
            'userTo' => $this->userTo,
            'recepient' => $this->recepient,
            'limitExist' => $this->limitExist,
        ]);
    }
}