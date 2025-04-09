<?php

namespace cabinet\widgets;

use yii\base\Widget;

class BreadcrumbMicro extends Widget
{
    public function run()
    {
        return $this->render('breadcrumb');
    }
}