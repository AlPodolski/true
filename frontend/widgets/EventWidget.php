<?php


namespace frontend\widgets;

use common\models\Event;
use Yii;
use yii\base\Widget;

class EventWidget extends Widget
{
    public $user_id;

    public function run()
    {

        if (!Yii::$app->user->isGuest)
            $events = Event::find()
                ->where(['user_id' => $this->user_id, 'status' => Event::NOT_READ_EVENT])
                ->count();

        return $this->render('event', [
            'events' => $events
        ]);

    }
}