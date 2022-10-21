<?php

namespace common\jobs;

use frontend\modules\user\helpers\ViewCountHelper;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class AddViewJob extends BaseObject implements JobInterface
{

    public $posts;
    public $type;

    public function execute($queue)
    {

        switch ($this->type){

            case 'redis_post_listing_view_count_key':
                foreach ($this->posts as $post){
                    ViewCountHelper::addView($post['id'], Yii::$app->params[$this->type]);
                }
                break;

            case 'redis_post_single_view_count_key':
                ViewCountHelper::addView($this->posts['id'], Yii::$app->params['redis_post_single_view_count_key']);
            break;

        }


    }
}