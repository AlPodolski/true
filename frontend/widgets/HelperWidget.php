<?php

namespace frontend\widgets;

use frontend\repository\HelperRepository;
use yii\base\Widget;
use Yii;

class HelperWidget extends Widget
{
    public function run()
    {

        if ($_COOKIE['helper']) return '';

        $viewNeedCount = \Yii::$app->params['view_post_count_for_helper'];
        $postViewCount = 0;

        $cookies = Yii::$app->request->cookies;

        if ($viewPosts = $cookies->get('view_post')){;

            $postsIds = \unserialize($viewPosts);

            $postViewCount = count($postsIds);

        }

        $viewNeedCount = $viewNeedCount - $postViewCount;

        $posts = false;

        if ($viewNeedCount <= 0) {

            $posts = (new HelperRepository())->getPostForHelper($postsIds);

        }

        return $this->render('helper', compact('viewNeedCount', 'posts'));
    }
}