<?php


namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;

class PayForm extends Model
{
    public $sum;

    public $user;

    public $public_key;

    public function rules()
    {
        return [
            [['sum', 'user', 'public_key'], 'required'],
            [['sum', 'user'], 'integer'],
            [['public_key'], 'string'],
        ];
    }

    public function pay()
    {

        $params = [
            'publicKey' => $this->public_key,
            'amount' => $this->sum,
            'account' => $this->user
        ];

        $billPayments = new \Qiwi\Api\BillPayments();

        return $billPayments->createPaymentForm($params);

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sum' => 'Сумма',
        ];
    }

}