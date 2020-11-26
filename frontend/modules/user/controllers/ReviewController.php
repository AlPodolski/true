<?php


namespace frontend\modules\user\controllers;

use frontend\modules\user\models\ReviewForm;
use Yii;
use yii\web\Controller;

class ReviewController extends Controller
{
    public function actionAdd()
    {

/*        if (Yii::$app->user->isGuest){

            Yii::$app->session->setFlash('warning', 'Ошибка. Требуется авторизация');

            return $this->redirect(Yii::$app->request->referrer, 302);

        }*/

        if (Yii::$app->request->isPost){

            $postReviewForm = new ReviewForm();

            $postReviewForm->author_id = 1;

            if (
                $postReviewForm->load(Yii::$app->request->post())
                and $postReviewForm->validate()
                and $reviewParams = $postReviewForm->save()
            )
            {

                Yii::$app->session->setFlash('success', 'Спасибо, Ваш отзыв добавлен');

                return $this->redirect(Yii::$app->request->referrer, 302);
            }

        }

        return $this->redirect(Yii::$app->request->referrer, 302);

    }
}