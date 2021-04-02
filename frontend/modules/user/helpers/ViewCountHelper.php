<?php


namespace frontend\modules\user\helpers;

use Yii;
use yii\redis\Connection;

class ViewCountHelper
{

    public static function addView($post_id , $key ){

        /* @var $redis Connection */
        $redis = Yii::$app->redis;

        $redis->INCR($key.":{$post_id}:view");

    }

    public static function countView($item_id , $key)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->GET ($key.":{$item_id}:view");
    }

}