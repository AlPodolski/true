<?php


namespace frontend\controllers;

use common\models\Claim;
use Yii;
use yii\web\Controller;

class ClaimController extends Controller
{
    public function actionGetModal()
    {

        $claimModal = new Claim();

        return $this->renderFile(Yii::getAlias('@frontend/views/claim/claim_form.php'), [
            'claimModal' => $claimModal
        ]);
    }

    public function actionAdd()
    {

        $claimForm = new Claim();

        if ($claimForm->load(Yii::$app->request->post()) and $claimForm->save()){

            Yii::$app->session->setFlash('success', 'Ваше обращение добавлено');

            return $this->redirect('/');

        }else{

            Yii::$app->session->setFlash('warning', 'Ошибка, попробуйте еще раз');

            return $this->redirect('/');

        }
    }
}