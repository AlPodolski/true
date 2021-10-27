<?php

namespace console\controllers;

use backend\models\Posts;
use common\models\City;
use frontend\modules\user\models\PostSites;
use Yii;
use yii\base\Controller;
use yii\helpers\ArrayHelper;

class ExportController extends Controller
{
    public function actionIndex()
    {
        $cityList = City::find()->asArray()->all();

        $postUrl = array();

        foreach ($cityList as $cityItem){

            $posts = Posts::find()
                ->where(['city_id' => $cityItem['id']])
                ->with('gallery')
                ->all();

            if ($posts) {

                foreach ($posts as $post){

                    if (\count($post->gallery) > 5)
                        $postUrl[$cityItem['url']][] = 'https://'.$cityItem['url'].'.sex-true.com/post/'.$post['id'];

                }

            }

        }

        \file_put_contents(Yii::getAlias("@frontend/web/files/file.txt"), \serialize($postUrl));

    }
}