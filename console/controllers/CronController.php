<?php

namespace console\controllers;

use frontend\modules\user\models\Posts;
use frontend\modules\user\models\TopAnketBlock;
use yii\console\Controller;

class CronController extends Controller
{
    public function actionUp ()
    {
        $posts = Posts::find()
            ->with('avatar')
            ->where(['user_id' => 22038])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->limit(3)
            ->orderBy('RAND()')
            ->all();

        foreach ($posts as $post){

            $upAnketModel = new TopAnketBlock();

            $upAnketModel->post_id = $post['id'];
            $upAnketModel->city_id = 1;
            $upAnketModel->valid_to = \time() + 3600;

            $upAnketModel->save();

        }
    }
}