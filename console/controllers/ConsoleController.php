<?php


namespace console\controllers;

use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use Yii;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionCountRating()
    {

        $posts = Posts::find()->all();

        foreach ($posts as $post){

            $tempData = $this->countCtr($post['id']);

            if ($tempData['phoneViewCtr'] > 0 and $tempData['pageViewCtr'] > 0) {

                $data = (($tempData['pageViewCtr'] * 2) + ($tempData['phoneViewCtr'] * 6));

                $raiting = (int) (10000 / $data);

                if ($raiting) {

                    $post->sort = $raiting;

                    $post->save();

                }

            }else{

                $post->sort = 10000;

                $post->save();

            }

        }

    }

    private function countCtr($id){

        $showPostCount = ViewCountHelper::countView($id, Yii::$app->params['redis_post_listing_view_count_key']);

        $phoneViewCount = ViewCountHelper::countView($id, Yii::$app->params['redis_view_phone_count_key']);

        $singlePageViewCount = ViewCountHelper::countView($id, Yii::$app->params['redis_post_single_view_count_key']);

        if ($showPostCount > 0 and $singlePageViewCount > 0) $pageViewCtr = $showPostCount / $singlePageViewCount;
        else $pageViewCtr = 0;

        if ($singlePageViewCount > 0 and $phoneViewCount > 0) $phoneViewCtr = $showPostCount / $phoneViewCount;
        else $phoneViewCtr = 0;

        return [
            'phoneViewCtr' => $phoneViewCtr,
            'pageViewCtr' => $pageViewCtr,
        ];

    }

}