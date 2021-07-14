<?php


namespace frontend\modules\user\controllers;

use frontend\modules\user\models\forms\AddPhoneReviewForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PhoneController extends Controller
{
    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-info' => ['POST'],
                    'add-review' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionAddReview($city)
    {

        $userParams = \json_decode(Yii::$app->phone->send(['action' => 'get-category']));

        $reviewForm = new AddPhoneReviewForm();

        if ($reviewForm->load(Yii::$app->request->post()) ){

            $reviewForm->category = Yii::$app->request->post('category');

            if ($reviewForm->validate()){

                $reviewForm->send();

                Yii::$app->session->setFlash('success', 'Спасибо, отзыв добавлен');

                return $this->redirect('/cabinet');

            }

        }

        return $this->render('add-review', [
            'userParams' => $userParams,
            'reviewForm' => $reviewForm,
        ]);
    }

    public function actionGetInfo()
    {
        if (!$phone = Yii::$app->request->post('phone')) return 'Нужно указать номер';

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (mb_strlen($phone) != 11) return 'Указан неверный номер, должно быть 11 сиволов';

        $data = \json_decode(Yii::$app->phone->send(['phone' => $phone, 'action' => 'get-review']));

        return $this->renderFile(Yii::getAlias('@frontend/modules/user/views/phone/review.php'), [
            'data' => $data
        ]);

    }

}