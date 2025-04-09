<?php


namespace cabinet\modules\user\controllers;

use cabinet\modules\user\models\forms\AddPhoneReviewForm;
use cabinet\modules\user\models\Posts;
use Yii;
use yii\filters\VerbFilter;
use cabinet\modules\user\controllers\CabinetBeforeController as Controller;

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

    public function actionUpdate()
    {
        $data = json_decode(Yii::$app->request->post('data'));
        $phone = Yii::$app->request->post('phone');

        if ($data and $phone){

            $phone = preg_replace('/[^0-9]/', '', $phone);

            Posts::updateAll(['phone' => $phone], ['and' , ['user_id' => Yii::$app->user->id], [ 'in', 'id', $data]]);

        }
    }

    public function actionGetModal()
    {
        return $this->renderFile(Yii::getAlias('@cabinet/modules/user/views/phone/form.php'));
    }

    public function actionAddReview($city)
    {
        return $this->redirect('/cabinet');

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

        $phone = null;

        if ($phone = Yii::$app->request->get('phone')) {

            $phone = preg_replace('/[^0-9]/', '', $phone);

        }

        return $this->render('add-review', [
            'userParams' => $userParams,
            'reviewForm' => $reviewForm,
            'phone' => $phone,
        ]);
    }

    public function actionGetInfo()
    {

        return $this->redirect('/cabinet');

        if (!$phone = Yii::$app->request->post('phone')) return 'Нужно указать номер';

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (mb_strlen($phone) != 11) return 'Указан неверный номер, должно быть 11 сиволов';

        $data = \json_decode(Yii::$app->phone->send(['phone' => $phone, 'action' => 'get-review']));

        return $this->renderFile(Yii::getAlias('@cabinet/modules/user/views/phone/review.php'), [
            'data' => $data
        ]);

    }

}