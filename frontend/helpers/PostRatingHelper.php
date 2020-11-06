<?php


namespace frontend\helpers;

use frontend\modules\user\models\Review;
use yii\helpers\ArrayHelper;

class PostRatingHelper
{
    public static function getPostRating($postId)
    {

        $postReview = Review::find()->where(['post_id' => $postId])->asArray()->all();

        if (($reviewCount = count($postReview)) == 0 ) return 0;

        $photo_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'photo_marc'));
        $service_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'service_marc'));
        $total_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'total_marc'));
        $clean_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'clean'));

        $result = array(
            'photo_marc' => $photo_marc,
            'service_marc' => $service_marc,
            'total_marc' => $total_marc,
            'clean_marc' => $clean_marc,
            'total_rating' => self::getTotalRating($photo_marc, $service_marc,$total_marc )
        );

        return $result;

    }

    public static function getAverageRating($total, $marc)
    {
        $averageRating = 0;

        foreach ($marc as $item){

            $averageRating = $averageRating + $item;

        }

        return \round($averageRating / $total , 1);

    }

    public static function getTotalRating()
    {
        $arguments = func_get_args();

        $total = 0;

        foreach ($arguments as $item) {

            $total = $total + $item;

        }

        return \round($total / \count($arguments), 1);

    }

}