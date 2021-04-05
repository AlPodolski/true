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

        $posts = Posts::find()->with('selphiCount', 'nacionalnost', 'cvet',
            'strizhka', 'osobenost', 'serviceDesc', 'service')->all();

        foreach ($posts as $post){

            $tempData = $this->countCtr($post['id']);

            if ($tempData['phoneViewCtr'] > 0 and $tempData['pageViewCtr'] > 0) {

                $data = (($tempData['pageViewCtr'] * 2) + ($tempData['phoneViewCtr'] * 6));

            }

            $postRating = \frontend\helpers\PostRatingHelper::getPostRating($post['id']);

            if ($postRating){

                $data = $data + $postRating['total_rating'];

            }

            if ($post['service']){

                $data = $data + 1;

            }
            if ($post['serviceDesc']){

                $data = $data + 1;

            }
            if ($post['osobenost']){

                $data = $data + 1;

            }
            if ($post['strizhka']){

                $data = $data + 1;

            }
            if ($post['cvet']){

                $data = $data + 1;

            }
            if ($post['nacionalnost']){

                $data = $data + 1;

            }
           if ($post['selphiCount']){

                $data = $data + 1;

            }

            if ($post['check_photo_status']){

                $data = $data + 2;

            }

            if ($post['video']){

                $data = $data + 1;

            }

            if ($post['age']){

                $data = $data + 1;

            }

            if ($post['rost']){

                $data = $data + 1;

            }

            if ($post['breast']){

                $data = $data + 1;

            }

            if ($post['ves']){

                $data = $data + 1;

            }

            $raiting = (int) (10000 / $data);

            if ($raiting) {

                $post->sort = $raiting;

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