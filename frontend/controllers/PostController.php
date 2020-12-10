<?php


namespace frontend\controllers;

use frontend\modules\user\helpers\ServiceReviewHelper;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\ReviewForm;
use frontend\modules\user\models\ServiceReviewForm;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionIndex($city, $id)
    {
        $post = Posts::find()->where(['id' => $id])
            ->with('allPhoto', 'metro', 'avatar', 'place', 'service',
                'sites', 'rayon', 'nacionalnost',
                'cvet', 'strizhka', 'osobenost'
            )
            ->asArray()->one();

        $serviceList = ServiceReviewHelper::getPostServiceReview($id);

        $postReviewForm = new ReviewForm();

        $serviceReviewFormForm = new ServiceReviewForm();

        return $this->render('single', [
            'post' => $post,
            'serviceList' => $serviceList,
            'id' => $id,
            'postReviewForm' => $postReviewForm,
            'serviceReviewFormForm' => $serviceReviewFormForm,
        ]);

    }
}