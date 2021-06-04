<?php


namespace frontend\modules\user\models\forms;

use common\models\TelegramToken;
use yii\base\Model;

class CheckTelegramForm extends Model
{

    public $token;
    public $user_id;

    private $_telegram_token;

    public function rules()
    {
        return [
            [['token'] , 'string'],
            [['token'] , 'trim'],
            [['token'] , 'validateToken'],
            [['user_id'] , 'integer'],
            [['user_id', 'user_id'] , 'required'],
        ];
    }

    public function validateToken($attribute, $params)
    {
        if (!$this->hasErrors()) {

            if (!$this->getToken()) $this->addError('Неверный код');

        }
    }

    /**
     * Finds token by [[token,status]]
     *
     * @return TelegramToken|null
     */

    protected function getToken()
    {

        if ($this->_telegram_token === null){

            $this->_telegram_token = TelegramToken::findOne(['token' => $this->token, 'token_status' => TelegramToken::TOKEN_STATUS_NOT_ACTIVE]);

        }

        return $this->_telegram_token;

    }

    public function checkStatus()
    {

        $this->_telegram_token->token_status = TelegramToken::TOKEN_STATUS_ACTIVE;
        $this->_telegram_token->user_id = $this->user_id;

        return $this->_telegram_token->save();
    }

}