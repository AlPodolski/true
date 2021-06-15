<?php


namespace frontend\modules\user\models\forms;

use common\models\ObmenkaCurrency;
use common\models\ObmenkaOrder;
use frontend\modules\user\components\obmenka\Obmenka;
use Yii;
use yii\base\Model;

class ObmenkaPayForm extends Model
{

    public $user_id;
    public $sum;
    public $currency;
    public $city;
    public $toUser;
    public $pay_info;
    public $action;

    public function rules()
    {
        return [
            [['user_id', 'sum', 'currency'], 'required'],
            [['user_id', 'sum', 'toUser', 'pay_info', 'action'], 'integer'],
            [['city'], 'string'],
            [['currency'] , 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'sum' => 'Сумма',
            'created_at' => 'Created At',
            'currency' => 'Выбрать способ оплаты',
            'status' => 'Status',
            'pay_info' => 'Status',
        ];
    }

    public function createPay()
    {

        if ($order = $this->createOrder() and $currency = ObmenkaCurrency::findOne($this->currency)){

            $obmenka = new Obmenka();

            if ($payUrl = $obmenka->getPayUrl($order->id.'-'.Yii::$app->params['obm-id-pref'], $order->sum, $this->city, $currency['value'])){

                return $payUrl;

            }

        }

        return false;

    }

    private function createOrder(){

        $order = new ObmenkaOrder();

        $order->user_id = $this->user_id;
        $order->sum = $this->sum;
        $order->status = ObmenkaOrder::WAIT;
        $order->pay_info = $this->pay_info;
        $order->user_to = $this->toUser;

        if ($order->save()) return $order;

        return false;

    }
}