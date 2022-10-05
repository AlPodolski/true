<?php

namespace frontend\modules\user\components\helpers;
use frontend\modules\user\helpers\ViewCountHelper;
use Yii;

class ViewPostCountHelper
{
    public static function count($posts)
    {
        if ($posts){

            $data = [
                'phone_view' => 0,
                'post_show' => 0,
                'post_view' => 0,
            ];

            foreach ($posts as $post){

                $phoneView = ViewCountHelper::countView($post['id'], Yii::$app->params['redis_view_phone_count_key']) ?? 0;
                $postShow = ViewCountHelper::countView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']) ?? 0;
                $postView = ViewCountHelper::countView($post['id'], Yii::$app->params['redis_post_single_view_count_key']) ?? 0;

                $data = [
                    'phone_view' => $data['phone_view'] + $phoneView,
                    'post_show' => $data['post_show'] + $postShow,
                    'post_view' => $data['post_view'] + $postView,
                ];

            }

            return $data;

        }

        return false;

    }
}