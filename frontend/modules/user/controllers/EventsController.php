<?php


namespace frontend\modules\user\controllers;

use common\models\Event;
use frontend\components\helpers\EventHelper;
use Yii;
use frontend\controllers\BeforeController as Controller;

class EventsController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionIndex($city)
    {

        $events = Event::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->limit(20)
            ->orderBy('id DESC')
            ->with('post')
            ->all();

        if ($events) EventHelper::setRead($events);

        return $this->render('index', [
            'events' => $events
        ]);

    }
}