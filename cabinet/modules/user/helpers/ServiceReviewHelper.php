<?php


namespace cabinet\modules\user\helpers;


use common\models\Service;
use cabinet\helpers\PostRatingHelper;
use cabinet\modules\user\models\ServiceReviews;
use yii\helpers\ArrayHelper;

class ServiceReviewHelper
{
    public static function getPostServiceReview($postId)
    {

        $serviceList = Service::find()->asArray()->all();

        foreach ($serviceList as &$serviceItem){

             $serviceMarc = ServiceReviews::find()
                ->where(['service_id' => $serviceItem['id'], 'post_id' => $postId])
                ->select('marc')
                ->asArray()->all();

            $serviceMarc = ArrayHelper::getColumn($serviceMarc, 'marc');

            $serviceItem['review'] = PostRatingHelper::getAverageRating(\count($serviceMarc), $serviceMarc);

        }

        return $serviceList;

    }
}