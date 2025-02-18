<?php


namespace frontend\helpers;

use common\models\City;
use frontend\modules\user\models\Review;
use Yii;
use yii\helpers\ArrayHelper;
use function Symfony\Component\String\s;

class PostRatingHelper
{
    public static function getPostRating($postId)
    {

        $postReview = self::getReview($postId);

        $reviewCount = count($postReview);
        $service_marc = self::getAverageServiceRating( ArrayHelper::getColumn($postReview, 'serviceMarc'));
        $photo_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'photo_marc'));
        $total_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'total_marc'));
        $clean_marc = self::getAverageRating($reviewCount, ArrayHelper::getColumn($postReview, 'clean'));
        $happy_marc_count = self::countHappy(ArrayHelper::getColumn($postReview, 'is_happy'), 1);
        $not_happy_marc_count = self::countHappy(ArrayHelper::getColumn($postReview, 'is_happy'), 0);

        return array(
            'review' => $postReview,
            'photo_marc' => $photo_marc,
            'service_marc' => $service_marc,
            'total_marc' => $total_marc,
            'clean_marc' => $clean_marc,
            'happy_marc_count' => $happy_marc_count,
            'not_happy_marc_count' => $not_happy_marc_count,
            'total_rating' => self::getTotalRating($photo_marc, $service_marc,$total_marc , $clean_marc)
        );

    }

    public static function getReview($postId)
    {
        $data = Yii::$app->cache->get(Yii::$app->params['review_cache_key'].'_'.$postId);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = Review::find()->where(['post_id' => $postId, 'is_moderate' => Review::MODARATE])->with('serviceMarc', 'author')->asArray()->all();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('review_'.$postId, $data);
        }

        return $data;
    }

    public static function countHappy($marc, $needCount = 1)
    {

        $count = 0;

        foreach ($marc as $item){

            if ($item == $needCount) $count++;

        }

        return $count;

    }

    public static function getAverageRating($total, $marc)
    {

        if (!$marc) return 0;

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
        if ($total == 0) return 0;
        return \round($averageRating / $total , 1);

    }

    public static function getTotalRating()
    {
        $arguments = func_get_args();

        $total = 0;

        foreach ($arguments as $item) {

            $total = $total + $item;

        }
        if ($total == 0) return 0;
        return \round($total / \count($arguments), 1);

    }

    public static function setPercentRating($rating)
    {
        return $rating * 10;
    }

}