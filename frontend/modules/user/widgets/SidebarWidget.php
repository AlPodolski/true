<?php


namespace frontend\modules\user\widgets;

use yii\base\Widget;

class SidebarWidget extends Widget
{
    public $user;

    public function run()
    {
        return $this->render('sidebar', [
            'user' => $this->user
        ]);
    }
}