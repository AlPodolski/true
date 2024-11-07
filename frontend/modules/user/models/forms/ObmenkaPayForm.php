<?php


namespace frontend\modules\user\models\forms;

use common\models\ObmenkaCurrency;
use common\models\ObmenkaOrder;
use frontend\modules\user\components\obmenka\Obmenka;
use frontend\modules\user\components\obmenka\PayService;
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
            [['sum'], 'integer', 'min' => $this->defineMinSum()],
            [['city'], 'string'],
            [['currency'] , 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {

        $data = [
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'currency' => 'Выбрать способ оплаты',
            'status' => 'Status',
            'sum' => 'Минимум '.$this->defineMinSum(),
            'pay_info' => 'Status',
        ];

        return $data;

    }

    private function defineMinSum(){

        return 2000;

    }

    public function createPay()
    {

        $currency = ObmenkaCurrency::findOne($this->currency);

        if ($order = $this->createOrder($currency->payment_system) ){

            $payService = new PayService($currency->payment_system);

            $sum = $order->sum;

            if ($currency['value'] == 'usdt_trc20') $sum = $order->sum / Yii::$app->params['usdt_curst'];

            if ($payUrl = $payService->getPayUrl($order->id.'-'.Yii::$app->params['obm-id-pref'], $sum, $this->city, $currency['value'])){

                $order->link = $payUrl;

                $order->save();

                return $payUrl;

            }

        }

        return false;

    }

    private function createOrder($payment_system){

        $order = new ObmenkaOrder();

        $order->user_id = $this->user_id;
        $order->sum = $this->sum;
        $order->status = ObmenkaOrder::WAIT;
        $order->pay_info = $this->pay_info;
        $order->user_to = $this->toUser;
        $order->payment_system = $payment_system;

        if ($order->save()) return $order;

        return false;

    }
}