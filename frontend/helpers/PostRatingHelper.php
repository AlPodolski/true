<?php


namespace frontend\helpers;

use frontend\modules\user\models\Review;
use yii\helpers\ArrayHelper;

class PostRatingHelper
{
    public static function getPostRating($postId)
    {

        $postReview = Review::find()->where(['post_id' => $postId])->with('serviceMarc')->asArray()->all();

        if (($reviewCount = count($postReview)) == 0 ) return 0;
        $service_marc = self::getAverageServiceRating( ArrayHelper::getColumn($postReview, 'serviceMarc'));
        $photo_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'photo_marc'));
        $total_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'total_marc'));
        $clean_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'clean'));

        $result = array(
            'photo_marc' => $photo_marc,
            'service_marc' => $service_marc,
            'total_marc' => $total_marc,
            'clean_marc' => $clean_marc,
            'total_rating' => self::getTotalRating($photo_marc, $service_marc,$total_marc , $clean_marc)
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
    public static function getAverageServiceRating( $marc)
    {
        $averageRating = 0;
        $total = 0;

        foreach ($marc as $item){

            if (\is_array($item)){

                foreach ($item as $value){

                    $total++;

                    $averageRating = $averageRating + $value['marc'];

                }

            }

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