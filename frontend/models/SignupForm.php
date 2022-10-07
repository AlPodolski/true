<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $city_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'common\models\User', 'message' => 'Такая почта уже используется'],

            ['city_id', 'integer'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User | false
     */
    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $emailBlockList = ['mailto.plus', 'fexbox.org', 'inpwa.com', 'mailbox.in.ua', 'rover.info', 'fexpost.com'];

        foreach ($emailBlockList as $item){

            if (strstr($this->email, $item)) return false;

        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->city_id = $this->city_id;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if ($user->save() && $this->sendEmail($user)) return $user;

        return false;

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Регистрация на сайте ' . Yii::$app->name)
            ->send();
    }
}
