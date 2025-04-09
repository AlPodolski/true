<?php


namespace cabinet\modules\user\models\forms;

use common\models\User;
use Yii;
use yii\base\Model;

class EditProfileForm extends Model
{
    public $username;
    public $age;
    public $avatar;
    public $male;
    public $user_id;
    public $notify;
    public $open_message;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['age', 'integer', 'min' => 18, 'max' => 99],
            ['male', 'integer', 'min' => 0, 'max' => 1],
            ['notify', 'integer', 'min' => 0, 'max' => 1],
            ['open_message', 'integer', 'min' => 0, 'max' => 1],
            ['user_id', 'integer'],
            ['username', 'trim'],
            ['avatar', 'safe'],
            ['username', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'age' => 'Возраст',
            'male' => 'Пол',
            'avatar' => 'Аватар',
            'notify' => 'Получать уведомлений',
            'open_message' => 'Получать сообщения от других пользователей',
        ];
    }

    public function save()
    {
        $user = User::findOne($this->user_id);



        $user->male = $this->male;
        $user->username = $this->username;
        $user->age = $this->age;
        $user->notify = $this->notify;
        $user->open_message = $this->open_message;

        return $user->save();
    }

}