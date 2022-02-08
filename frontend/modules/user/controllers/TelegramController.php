<?php


namespace frontend\modules\user\controllers;

use common\models\User;
use common\components\helpers\TelegramHelper;
use frontend\modules\user\models\forms\CheckTelegramForm;
use Yii;
use frontend\controllers\BeforeController as Controller;

class TelegramController extends Controller
{
    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionIndex($city)
    {

        $user = User::find()->where(['id' => Yii::$app->user->id])->with('avatar')->one();

        $tokenForm = new CheckTelegramForm();

        $tokenForm->user_id = Yii::$app->user->id;

        if ($tokenForm->load(Yii::$app->request->post()) and $tokenForm->validate() and $token = $tokenForm->checkStatus()){

            TelegramHelper::sendMenu($token->telegram_chat_id);

            Yii::$app->session->setFlash('success', 'Телеграм подтвержден');

            return $this->redirect('/cabinet');

        }

        if ($tokenForm->hasErrors())  Yii::$app->session->setFlash('warning', $tokenForm->getFirstErrors());

        return $this->render('index', [
            'user' => $user,
            'tokenForm' => $tokenForm
        ]);
    }

}