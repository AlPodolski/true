<?php

namespace cabinet\modules\user\controllers;

use common\models\Tarif;
use common\models\User;
use cabinet\modules\user\components\helpers\ViewPostCountHelper;
use cabinet\modules\user\helpers\CabinetViewHelper;
use cabinet\modules\user\models\Posts;
use Yii;
use cabinet\modules\user\controllers\CabinetBeforeController as Controller;

class CabinetController extends Controller
{

    public function actionIndex($city)
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect('/login');
        }

        $user = User::find()->where(['id' => Yii::$app->user->id])->with('avatar', 'telegram')->one();

        $posts = Posts::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with('avatar', 'message', 'city')
            ->all();

        $viewType = (new CabinetViewHelper())->get();

        $statData = ViewPostCountHelper::count($posts);

        $tarifList = Tarif::find()->all();

        return $this->render('index', [
            'user'  => $user,
            'posts' => $posts,
            'viewType' => $viewType,
            'tarifList' => $tarifList,
            'statData' => $statData,
        ]);

    }
    public function actionFaq($city)
    {
        return $this->render('faq');
    }

}
