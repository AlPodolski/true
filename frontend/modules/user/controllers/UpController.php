<?php


namespace frontend\modules\user\controllers;

use common\components\service\history\HistoryService;
use common\models\City;
use common\models\History;
use common\models\User;
use frontend\components\events\BillPayEvent;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\TopAnketBlock;
use Yii;
use frontend\modules\user\controllers\CabinetBeforeController as Controller;

class UpController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    const EVENT_BILL_PAY = 'bill_pay';

    public function init()
    {

        $this->on(self::EVENT_BILL_PAY, [HistoryService::class, 'addToHistory']);

        parent::init();

    }

    public function actionIndex($city)
    {

        $id = Yii::$app->request->post('id');

        $post = Posts::find()
            ->where(['id' => $id])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->limit(1)->one();

        $message = '';

        if ($post) {

            if ($post->status == Posts::POST_ON_MODARATION_STATUS or $post->status == Posts::RETURNED_FOR_REVISION) exit();

            $cityInfo = City::getCity($city);

            $user = User::findOne(Yii::$app->user->id);

            if ($post->sort >= (time() - 1)) {

                $message = 'Анкета уже поднята';

                return $message;

            }

            if ($user['cash'] >= Yii::$app->params['up_anket_cost']) {

                $transaction = Yii::$app->db->beginTransaction();

                $upAnketModel = new TopAnketBlock();

                $upAnketModel->post_id = $post['id'];
                $upAnketModel->city_id = $cityInfo['id'];
                $upAnketModel->valid_to = \time() + 3600;

                $user->cash = $user->cash - Yii::$app->params['up_anket_cost'];

                $post->status = Posts::POST_ON_PUPLICATION_STATUS;

                $post->sort = time();

                $post->save();

                if ($upAnketModel->save() and $user->save()) {

                    $transaction->commit();

                    $billPayEvent = new BillPayEvent();

                    $billPayEvent->user_id = $user['id'];
                    $billPayEvent->sum = Yii::$app->params['up_anket_cost'];
                    $billPayEvent->type = History::UP_ANKET;
                    $billPayEvent->balance = $user->cash;

                    $this->trigger(self::EVENT_BILL_PAY, $billPayEvent);

                    $message = 'Анкета поднята';

                } else {

                    $transaction->rollBack();

                    $message = 'Ошибка';

                }

            } else {

                $message = 'Недостаточно средств';

            }

        }

        return $message;

    }


}