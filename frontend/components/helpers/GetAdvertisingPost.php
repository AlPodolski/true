<?php

namespace frontend\components\helpers;

use frontend\modules\user\models\Posts;
use Yii;

class GetAdvertisingPost
{
    public static function get($city)
    {

        if (\Yii::$app->request->url == '/pol-muzhskoj') $pol_id = 2;
        else $pol_id = 1;

        if ($post = Posts::find()
            ->with('avatar')
            ->where(['city_id' => $city['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['pol_id' => $pol_id])
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