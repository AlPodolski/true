<?php

namespace cabinet\widgets;

use Yii;
use yii\base\Widget;

class Alert extends Widget
{
    public function run()
    {

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        return $this->render('alert', compact('flashes', 'session'));

    }
}