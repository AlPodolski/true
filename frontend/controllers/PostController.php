<?php


namespace frontend\controllers;

use frontend\modules\user\helpers\ServiceReviewHelper;
use frontend\modules\user\models\Posts;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionIndex($city, $id)
    {
        $post = Posts::find()->where(['id' => $id])
            ->with('allPhoto', 'metro', 'avatar', 'place', 'service', 'sites')
            ->asArray()->one();

        $serviceList = ServiceReviewHelper::getPostServiceReview($id);

        return $this->render('single', [
            'post' => $post,
            'serviceList' => $serviceList,
        ]);

    }
}