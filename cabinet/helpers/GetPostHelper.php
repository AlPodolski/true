<?php

namespace cabinet\helpers;

use common\models\Pol;
use cabinet\modules\user\models\Posts;
use Yii;

class GetPostHelper
{
    public static function getForSingle($id, $city_id)
    {

        $post = Yii::$app->cache->get('post_cache_'.$id.'_'.$city_id);

        if ($post === false) {
            // $data нет в кэше, вычисляем заново
            $post = Posts::find()
                ->where(['id' => $id])
                ->andWhere(['city_id' => $city_id])
                ->with('gal', 'metro', 'avatar', 'place', 'service',
                    'rayon', 'nacionalnost', 'review',
                    'cvet', 'strizhka', 'selphiCount'
                )
                ->limit(1)->one();

            if ($post) Yii::$app->cache->set('post_cache_'.$id.'_'.$city_id , $post);
        }

        return $post;
    }

    public static function getByPhone($phone, $cityId)
    {

        if (!$phone) return false;

        $phone = mb_substr($phone, 1);

        $posts = Posts::find()
            ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost', 'city')
            ->andWhere(['city_id' => $cityId])
            ->andWhere(['like', 'phone', $phone])
            ->cache(3600 * 24)
            ->all();

        return $posts;
    }

    public static function getRecomend($cityId)
    {
        $posts = Posts::find()->asArray()
            ->with('avatar', 'metro')
            ->where(['city_id' => $cityId])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['pol_id' => Pol::WOMAN_POL])
            ->limit(3)
            ->orderBy(['rand()' => SORT_DESC])
            ->cache(300)
            ->all();

        return $posts;
    }

}