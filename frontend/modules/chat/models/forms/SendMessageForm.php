<?php

namespace frontend\modules\chat\models\forms;

use frontend\modules\chat\models\Chat;
use frontend\modules\chat\models\Message;
use frontend\modules\chat\models\relation\UserDialog;
use yii\base\Model;

class SendMessageForm extends Model
{
    public $text;
    public $from_id;
    public $chat_id;
    public $created_at;
    public $user_id;
    public $class;
    public $related_id;
    public $status = 0;
    public $type = Message::REGULAR_MESSAGE;


    public function rules()
    {
        return [
            [['from_id'], 'required'],
            [['from_id', 'chat_id', 'related_id', 'created_at'], 'integer'],
            [['text', 'class'], 'string'],
            [['user_id'], 'safe'],
        ];
    }

    public function save(){

        if (!empty($this->chat_id)){

            $message = new Message();

            $message->message = $this->text;
            $message->from = $this->from_id;
            $message->created_at = $this->created_at;
            $message->chat_id = $this->chat_id;
            $message->status = $this->status;
            $message->class = $this->class;
            $message->related_id = $this->related_id;
            $message->type = $this->type;

            if ($message->save()) return $this->chat_id;

        }else{

            $userDialogs = UserDialog::find()->where(['user_id' => $this->from_id])->select('dialog_id')->asArray()->all();

            $dialogs = UserDialog::find()->where([  'in' , 'dialog_id',$userDialogs ])->asArray()->all();

            foreach ($dialogs as $item){

                if ($item['user_id'] == $this->user_id){

                    $message = new Message();

                    $message->message = $this->text;
                    $message->from = $this->from_id;
                    $message->created_at = $this->created_at;
                    $message->chat_id = $item['dialog_id'];
                    $message->status = $this->status;
                    $message->class = $this->class;
                    $message->related_id = $this->related_id;
                    $message->type = $this->type;

                    if ($message->save()) return $item['dialog_id'];

                }

            }

                $dialog = new Chat();
                $dialog->timestamp = \time();

                $dialog->save();

                $userDialog = new UserDialog();
                $userDialog->user_id = $this->from_id;
                $userDialog->dialog_id = $dialog->id;

                $userDialog->save();

                $userDialog = new UserDialog();
                $userDialog->user_id = $this->user_id;
                $userDialog->dialog_id = $dialog->id;

                $userDialog->save();

                $message = new Message();

                $message->message = $this->text;
                $message->from = $this->from_id;
                $message->created_at = $this->created_at;
                $message->chat_id = $dialog->id;
                $message->status = $this->status;
                $message->class = $this->class;
                $message->related_id = $this->related_id;
                $message->type = $this->type;

                if ($message->save()) return $dialog->id;


        }

    }
}