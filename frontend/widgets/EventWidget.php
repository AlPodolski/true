<?php


namespace frontend\widgets;

use common\models\Event;
use yii\base\Widget;

class EventWidget extends Widget
{
    public $user_id;

    public function run()
    {

        $events = Event::find()->where(['user_id' => $this->user_id, 'status' => Event::NOT_READ_EVENT])->count();

        return $this->render('event', [
            'events' => $events
        ]);

    }
}