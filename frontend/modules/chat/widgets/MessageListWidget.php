<?php


namespace frontend\modules\chat\widgets;

use frontend\modules\chat\components\helpers\GetDialogsHelper;
use Yii;
use yii\base\Widget;

class MessageListWidget extends Widget
{

    public $user_id;

    public function run()
    {

        $dialogs = GetDialogsHelper::getDialogs($this->user_id);

        $withAdmin = false;

        foreach ($dialogs as $dialog){

            if($dialog['companion']['user_id'] == Yii::$app->params['admin_id']) {

                $withAdmin = true;

            }

        }

        if (!$withAdmin ){

            $result = array();

            $result['companion']['author']['username'] = 'Администрация';

            $result['lastMessage']['message'] = 'Написать в поддержку';

            $result['companion']['user_id'] = Yii::$app->params['admin_id'];

            $dialogs[] = $result;

        }

        return $this->render('dialog_list', [
            'dialogs' => $dialogs,
            'user_id' => $this->user_id,
        ]);
    }
}