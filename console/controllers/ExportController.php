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

        $postIdOnSites = ArrayHelper::getColumn(PostSites::find()->where(['site_id' => 1])->asArray()->all(), 'post_id');

        foreach ($cityList as $cityItem){

            $posts = Posts::find()
                ->where(['city_id' => $cityItem['id']])
                ->andWhere(['in', 'id', $postIdOnSites])
                ->asArray()
                ->all();

            if ($posts) {

                foreach ($posts as $post){

                    $postUrl[$cityItem['url']][] = 'https://'.$cityItem['url'].'.sex-true.com/post/'.$post['id'];

                }

            }

        }

        \file_put_contents(Yii::getAlias("@frontend/web/files/file.txt"), \serialize($postUrl));

    }
}