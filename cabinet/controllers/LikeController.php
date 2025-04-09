<?php

namespace cabinet\controllers;

use cabinet\helpers\LikeHelper;
use cabinet\modules\user\models\Posts;
use yii\web\Controller;

class LikeController extends Controller
{
    public function actionIndex($city)
    {
        $postId = \Yii::$app->request->post('id');
        $type = \Yii::$app->request->post('type');

        $post = Posts::find()->where(['id' => $postId])->one();

        if ($post){

            if ($type == 'like'){
                $post->likes = $post->likes + 1;
                LikeHelper::add($post->id, 'liked');
                LikeHelper::remove($post->id, 'disliked');
            }else{
                $post->likes = $post->likes - 1;
                LikeHelper::add($post->id, 'disliked');
                LikeHelper::remove($post->id, 'liked');
            }

            $post->save();

            \Yii::$app->cache->delete('post_cache_'.$postId.'_'.$post->city_id);

            return $post->likes;

        }
    }
}