<?php


namespace frontend\modules\user\widgets;

use frontend\modules\user\models\Posts;
use yii\base\Widget;

class SidebarWidget extends Widget
{
    public $user;

    public function run()
    {

        $countPosts = Posts::find()->where(['user_id' => $this->user->id])->count();

        return $this->render('sidebar', [
            'user' => $this->user,
            'countPosts' => $countPosts,
        ]);
    }
}