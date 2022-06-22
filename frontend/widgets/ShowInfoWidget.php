<?php

namespace frontend\widgets;

use yii\base\Widget;

class ShowInfoWidget extends Widget
{
    public function run()
    {
        $cookies = $_COOKIE;

        $showBonusInfo = $cookies['bonus'] ?? false;
        $showCashInfo = $cookies['cash'] ?? false;

        return $this->render('info', compact('showBonusInfo',
            'showCashInfo'));
    }
}