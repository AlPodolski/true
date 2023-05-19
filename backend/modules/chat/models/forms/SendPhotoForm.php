<?php


namespace backend\modules\chat\models\forms;

use frontend\models\Files;
use backend\modules\chat\models\Message;
use yii\base\Model;

class SendPhotoForm extends Model
{
    public $photo;
    public $user_id;
    public $dialog_id;
    public $photo_id;
    public $to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'dialog_id'], 'integer'],
            [['file' , 'to'], 'safe'],
        ];
    }

    public function save()
    {
        $message = new Message();

        $message->from = $this->user_id;
        $message->created_at = \time();
        $message->chat_id = $this->dialog_id;
        $message->status = 0;
        $message->class = Files::class;
        $message->related_id = $this->photo_id;

        if ($message->save()) return $message;

    }

}