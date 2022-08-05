<?php

namespace frontend\helpers;

use frontend\modules\user\models\Posts;
use Yii;

class GetPostHelper
{
    public static function getForSingle($id, $city_id)
    {

        $post = Yii::$app->cache->get('post_cache_'.$id);

        if ($post === false) {
            // $data нет в кэше, вычисляем заново
            $post = Posts::find()
                ->where(['id' => $id])
                ->andWhere(['city_id' => $city_id])
                ->with('gal', 'metro', 'avatar', 'place', 'service',
                    'sites', 'rayon', 'nacionalnost',
                    'cvet', 'strizhka', 'selphiCount', 'serviceDesc', 'partnerId'
                )
                ->asArray()->limit(1)->one();
            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('post_cache_'.$id , $post);
        }

        return $post;
    }

    public static function getByPhone($phone, $cityId)
    {
        $phone = mb_substr($phone, 1);

        $posts = Posts::find()
            ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost', 'city')
            ->andWhere(['city_id' => $cityId])
            ->andWhere(['like', 'phone', $phone])
            ->all();

        return $posts;
    }

}