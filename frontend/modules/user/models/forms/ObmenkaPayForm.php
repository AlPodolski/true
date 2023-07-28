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

        $pay = ObmenkaOrder::find()->where(['user_id' => Yii::$app->user->id, 'status' => ObmenkaOrder::FINISH])->count();

        if ($pay > 1) {

            if (Yii::$app->user->identity->getPostCount() > 9) return 700;

            else return 600;

        }

        return 500;

    }

    public function createPay()
    {

        if ($order = $this->createOrder() and $currency = ObmenkaCurrency::findOne($this->currency)){

            $obmenka = new Obmenka();

            $sum = $order->sum;

            if ($currency['value'] == 'usdt_trc20') $sum = $order->sum / Yii::$app->params['usdt_curst'];

            if ($payUrl = $obmenka->getPayUrl($order->id.'-'.Yii::$app->params['obm-id-pref'], $sum, $this->city, $currency['value'])){

                $order->link = $payUrl->pay_link;

                $order->save();

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