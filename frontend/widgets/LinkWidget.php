<?php


namespace frontend\widgets;

use common\models\Link;
use yii\base\Widget;

class LinkWidget extends Widget
{
    public $url;

    public function run()
    {
        $links = Link::find()
            ->where(['url' => $this->url])
            ->asArray()
            ->all();

        return $this->render('links', [
            'links' => $links
        ]);
    }
}