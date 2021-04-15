<?php


namespace frontend\modules\user\models\forms;

use common\components\service\history\HistoryService;
use common\models\History;
use common\models\User;
use frontend\components\events\BillPayEvent;
use frontend\modules\user\models\Posts;
use Yii;
use yii\base\BaseObject;
use yii\base\Model;

class BuyViewForm extends Model
{
    public $price;
    public $post_id;

    const EVENT_BILL_PAY = 'bill_pay';

    public function __construct()
    {

        $this->on(self::EVENT_BILL_PAY, [HistoryService::class, 'addToHistory']);

        parent::__construct();

    }


        /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price','post_id'], 'integer'],
            [['price','post_id'], 'required'],
        ];
    }

    public function save()
    {
        if($post = Posts::findOne($this->post_id)){

            $user = User::findOne(Yii::$app->user->id);

            $view = $this->getValue();

            if ($view and $user['cash'] >= $this->price){

                $transaction = Yii::$app->db->beginTransaction();

                $user['cash'] = $user['cash'] - $this->price;

                $post->view = $post->view + $view;

                if ($user->save() and $post->save()) {

                    $transaction->commit();

                    $billPayEvent = new BillPayEvent();

                    $billPayEvent->user_id = $user['id'];
                    $billPayEvent->sum = $this->price;
                    $billPayEvent->type = History::BUY_VIEW;
                    $billPayEvent->balance = $user->cash;

                    $this->trigger(self::EVENT_BILL_PAY, $billPayEvent);

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

    public function attributeLabels()
    {
        return [
            'price' => 'Купить показы',
        ];
    }

    public function getValue()
    {

        switch ($this->price) {
            case Yii::$app->params['view_100_buy_price']:
                return (100);
        }

        return false;

    }

}