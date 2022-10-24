<?php


namespace frontend\controllers;

use common\models\Claim;
use frontend\components\helpers\CaptchaHelper;
use frontend\models\forms\AnketClaimForm;
use Yii;
use frontend\controllers\BeforeController as Controller;

class ClaimController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'get-modal') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionGetModal()
    {

        $claimModal = new Claim();

        return $this->renderFile(Yii::getAlias('@frontend/views/claim/claim_form.php'), [
            'claimModal' => $claimModal
        ]);
    }

    public function actionAdd()
    {

/*        if (!CaptchaHelper::check()){

            Yii::$app->session->setFlash('warning' , 'Капча введена неверно');
            return Yii::$app->response->redirect(['/'], 301, false);

        }*/

        $claimForm = new Claim();

        $claimForm->ip = Yii::$app->request->userIP;

        if ($claimForm->load(Yii::$app->request->post()) and $claimForm->save()){

            Yii::$app->session->setFlash('success', 'Ваше обращение добавлено');

            return $this->redirect('/');

        }else{

            Yii::$app->session->setFlash('warning', 'Ошибка, попробуйте еще раз');

            return $this->redirect('/');

        }
    }

    public function actionClaimAnket()
    {

        if (!CaptchaHelper::check()){

            Yii::$app->session->setFlash('warning' , 'Капча введена неверно');
            return Yii::$app->response->redirect(['/post/'.Yii::$app->request->post('AnketClaimForm')['post_id']], 301, false);

        }

        $claimForm = new AnketClaimForm();

        if ($claimForm->load(Yii::$app->request->post()) and $claimForm->validate() and $claimForm->save()){

            Yii::$app->session->setFlash('success', 'Благодарим за Ваше обращение');

            return $this->redirect('/post/'.$claimForm->post_id);

        }

        Yii::$app->session->setFlash('warning', 'Ошибка');

        return $this->redirect('/post/'.$claimForm->post_id);

    }

}