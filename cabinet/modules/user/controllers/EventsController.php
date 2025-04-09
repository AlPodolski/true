<?php


namespace cabinet\modules\user\controllers;

use common\models\Event;
use cabinet\components\helpers\EventHelper;
use Yii;
use cabinet\modules\user\controllers\CabinetBeforeController as Controller;

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