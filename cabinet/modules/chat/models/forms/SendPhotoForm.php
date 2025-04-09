<?php


namespace cabinet\modules\chat\models\forms;

use cabinet\models\Files;
use cabinet\modules\chat\models\Chat;
use cabinet\modules\chat\models\Message;
use cabinet\modules\chat\models\relation\UserDialog;
use yii\base\Model;

class SendPhotoForm extends Model
{
    public $photo;
    public $file;
    public $user_id;
    public $chat_id;
    public $photo_id;
    public $to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'chat_id'], 'integer'],
            [['file' , 'to'], 'safe'],
        ];
    }

    public function save()
    {
        $message = new Message();
        $message->from = $this->user_id;
        $message->to = $this->to;
        $message->created_at = \time();
        $message->status = 0;
        $message->class = Files::class;
        $message->related_id = $this->photo_id;

        if (!empty($this->chat_id) ) {

            $message->chat_id = $this->chat_id;

        }else{

            $userDialogs = UserDialog::find()->where(['user_id' => $this->user_id])->select('dialog_id')->asArray()->all();

            $dialogs = UserDialog::find()->where(['in', 'dialog_id', $userDialogs])->asArray()->all();

            foreach ($dialogs as $item) {

                if ($item['user_id'] == $this->to) {

                    $message->chat_id = $item['dialog_id'];

                }

            }

            if (!$message->chat_id){

                $dialog = new Chat();

                $dialog->save();

                $dialog = new Chat();

                $dialog->save();

                $userDialog = new UserDialog();
                $userDialog->user_id = $this->user_id;
                $userDialog->dialog_id = $dialog->id;

                $userDialog->save();

                $userDialog = new UserDialog();
                $userDialog->user_id = $this->to;
                $userDialog->dialog_id = $dialog->id;

                $userDialog->save();

                $message->chat_id = $dialog->id;

            }



        }

        $message->save();

        if ($message->save()) return $message;

    }

}