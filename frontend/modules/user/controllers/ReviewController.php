<?php


namespace frontend\modules\user\controllers;

use frontend\modules\user\models\ReviewForm;
use frontend\modules\user\models\ServiceReviewForm;
use Yii;
use frontend\controllers\BeforeController as Controller;

class ReviewController extends Controller
{
    public function actionAdd()
    {

        if (Yii::$app->request->isPost){

            $postReviewForm = new ReviewForm();

            $postReviewForm->author_id = Yii::$app->user->id ?? null;

            if (
                $postReviewForm->load(Yii::$app->request->post())
                and $postReviewForm->validate()
                and $reviewParams = $postReviewForm->save()
            )
            {

                $serviceReviewForm = new ServiceReviewForm();

                if ( $serviceReviewForm->save($reviewParams['post_id'])){

                    Yii::$app->session->setFlash('success', 'Спасибо, Ваш отзыв добавлен');

                    return $this->redirect(Yii::$app->request->referrer, 302);

                }

            }

        }

        return $this->redirect(Yii::$app->request->referrer, 302);

    }
}