<?php

namespace frontend\components\helpers;

use frontend\models\Files;
use frontend\modules\user\models\Posts;

class GetAdvertisingPost
{
    public static function get($city)
    {

        if (\Yii::$app->request->url == '/pol-muzhskoj') $pol_id = 2;
        else $pol_id = 1;

        if ($post = Posts::find()
            ->leftJoin('files', 'files.related_id = posts.id and files.main = :type', [':type' => Files::MAIN_PHOTO])
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