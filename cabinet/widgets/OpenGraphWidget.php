<?php

namespace cabinet\widgets;

use yii\base\Widget;
use Yii;

class OpenGraphWidget extends Widget
{

    public $des;
    public $title;
    public $img;

    public function run()
    {

        Yii::$app->view->registerMetaTag([
            'name' => 'og:title',
            'content' => $this->title
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'og:description',
            'content' => $this->des
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'og:url',
            'content' => 'https://'.$_SERVER['HTTP_HOST'].Yii::$app->request->url
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'og:image',
            'content' => $this->img
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'og:site_name',
            'content' => $_SERVER['HTTP_HOST']
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'og:locale',
            'content' => 'ru_RU'
        ]);
    }
}