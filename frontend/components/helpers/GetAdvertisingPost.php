<?php


namespace frontend\components\helpers;


use frontend\modules\user\models\Posts;

class GetAdvertisingPost
{
    public static function get($city)
    {

        if ($post = Posts::find()
            ->with('avatar')
            ->where(['city_id' => $city['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['>', 'view', 0])
            ->limit(1)
            ->cache(60)
            ->orderBy('RAND()')
            ->one()){

            $post->view = $post->view - 1;

            $post->save();

            $checkBlock['block']['post'] = $post;

            $checkBlock['block']['url'] = '/post/'.$post['id'];

            return $checkBlock;

        }else{

            return false;

        }

    }
}