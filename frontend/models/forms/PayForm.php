<?php


namespace frontend\models\forms;

use common\models\User;
use frontend\models\Bill;
use Yii;
use yii\base\Model;

class PayForm extends Model
{
    public $sum;

    public $user_id;

    public $status;

    public $bill_id;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sum' => 'Сумма',
            'user_id' => 'ид пользователя',
            'status' => 'статус',
            'bill_id' => 'ид платежа',
        ];
    }

    public function rules()
    {
        return [
            [['sum', 'user_id', 'bill_id'], 'required'],
            [['sum', 'user_id', 'bill_id'], 'integer'],
            [['status'], 'string'],
        ];
    }

    public function pay()
    {
        if ($bill = Bill::findOne($this->bill_id) and $user = User::findOne($this->user_id)){

            if ($bill->status == Bill::WAITING and $this->status == 'PAID'){

                $bill->status = Bill::PAID;

                $user->cash = $user->cash + $this->sum;

                $transaction = Yii::$app->db->beginTransaction();

                if ($user->save() and $bill->save()) {

                    $transaction->commit();

                    return true;

                }

                else {

                    $transaction->rollBack();

                    return false;

                }

            }

        }

        return false;

    }

}