<?php


namespace frontend\controllers;

use common\models\City;
use frontend\helpers\RequestHelper;
use frontend\modules\user\helpers\ServiceReviewHelper;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\ReviewForm;
use frontend\modules\user\models\ServiceReviewForm;
use Yii;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionIndex($protocol,$city, $id)
    {
        $post = Posts::find()->where(['id' => $id])
            ->with('allPhoto', 'metro', 'avatar', 'place', 'service',
                'sites', 'rayon', 'nacionalnost',
                'cvet', 'strizhka', 'osobenost', 'selphiCount', 'serviceDesc'
            )
            ->asArray()->one();

        $serviceListReview = ServiceReviewHelper::getPostServiceReview($id);

        $postReviewForm = new ReviewForm();

        $serviceReviewFormForm = new ServiceReviewForm();

        $cityInfo = City::getCity($city);

        $backUrl = RequestHelper::getBackUrl($protocol);

        return $this->render('single', [
            'post' => $post,
            'serviceListReview' => $serviceListReview,
            'id' => $id,
            'postReviewForm' => $postReviewForm,
            'serviceReviewFormForm' => $serviceReviewFormForm,
            'cityInfo' => $cityInfo,
            'backUrl' => $backUrl,
        ]);

    }
}