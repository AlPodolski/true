<?php


namespace frontend\modules\user\models\forms;

use frontend\models\Bill;
use Yii;
use yii\base\Model;
use yii\db\Exception;

class PayForm extends Model
{
    public $sum;

    public $user;

    public $city;

    public function rules()
    {
        return [
            [['sum', 'user', 'city'], 'required'],
            [['user'], 'integer'],
            [['sum'], 'integer' , 'min' => Yii::$app->params['min_pay']],
            [['city'], 'string'],
        ];
    }

    public function pay()
    {

        try {

            $billPayments = new \Qiwi\Api\BillPayments(Yii::$app->params['qiwi_privite_key']);

            $bill = $this->createBill();

            $billId = $bill['id'];

            $fields = [
                'amount' => $bill->sum,
                'currency' => 'RUB',
                'successUrl' => 'https://'.$this->city.'.sex-tut.com/cabinet',
                'account' => $this->user,
            ];

            /** @var \Qiwi\Api\BillPayments $billPayments */
            return $billPayments->createBill($billId, $fields);

        }catch (Exception $e){

            throw new Exception('Ошибка ', $e->getMessage());

        }

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

    public function createBill()
    {
        $bill = new Bill();

        $bill->user_id = $this->user;
        $bill->sum = $this->sum;
        $bill->status = Bill::WAITING;

        if ($bill->save()) return $bill;

        else throw new Exception('Ошибка сохренения счета', $bill->getErrors());

    }

}