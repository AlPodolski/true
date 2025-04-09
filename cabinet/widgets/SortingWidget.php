<?php

namespace cabinet\widgets;

use yii\base\Widget;
use Yii;

class SortingWidget extends Widget
{
    public function run()
    {
        $cookies = $_COOKIE;
        if (isset($cookies['sort'])) $sort = $cookies['sort'];
        else $sort = 'default';
        return $this->render('sorting', compact('sort'));
    }
}