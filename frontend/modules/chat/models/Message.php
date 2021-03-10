<?php

namespace frontend\modules\chat\models;

use common\models\User;
use frontend\modules\chat\models\relation\UserDialog;
use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int|null $chat_id
 * @property int|null $from
 * @property string|null $message
 * @property int|null $created_at
 * @property int|null $status Отражает состояние сообщения, прочитано или нет
 * @property int $id
 * @property string $class
 * @property string $related_id
 * @property integer $type
 */
class Message extends \yii\db\ActiveRecord
{

    const REGULAR_MESSAGE = 1;
    const INVITING_MESSAGE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from'], 'required'],
            [['chat_id', 'from', 'created_at', 'status', 'related_id', 'type'], 'integer'],
            [['message', 'class'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'from' => 'From',
            'message' => 'Message',
            'created_at' => 'Created At',
            'status' => 'Status',
            'id' => 'ID',
        ];
    }

    public function getAuthor(){

        return $this->hasOne(User::class, ['id' => 'from'])->select('id, username')->with('avatar');

    }

    public function getDialog()
    {
        return $this->hasOne(UserDialog::class, ['dialog_id' => 'chat_id'])->andWhere(['<>', 'user_id', $this->from])->with('authorNoPhoto');
    }
}
