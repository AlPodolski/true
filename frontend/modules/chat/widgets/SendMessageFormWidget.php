<?php


namespace frontend\modules\chat\widgets;

use frontend\modules\chat\models\forms\SendMessageForm;
use Yii;
use yii\base\Widget;

class SendMessageFormWidget extends Widget
{

    public function init(){

    }

    public function run()
    {

        $model = new SendMessageForm();

        if (Yii::$app->user->isGuest) return '<p class="alert alert-info">Требуется авторизация</p>';

        return $this->render('send_message_form.php', [
            'model' => $model,
        ]);
    }
}