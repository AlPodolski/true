<?php

namespace frontend\widgets;

use yii\base\Widget;

class BreadcrumbMicro extends Widget
{
    public function run()
    {
        return $this->render('breadcrumb');
    }
}