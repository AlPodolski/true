<?php

namespace frontend\modules\user\controllers;

use common\models\Tarif;
use common\models\User;
use frontend\modules\user\helpers\CabinetViewHelper;
use frontend\modules\user\models\Posts;
use Yii;
use frontend\controllers\BeforeController as Controller;

class CabinetController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }


    public function actionIndex($city)
    {

        $user = User::find()->where(['id' => Yii::$app->user->id])->with('avatar', 'telegram')->one();

        $posts = Posts::find()->where(['user_id' => Yii::$app->user->id])->with('avatar', 'message')->all();

        $viewType = (new CabinetViewHelper())->get();

        $tarifList = Tarif::find()->all();

        return $this->render('index', [
            'user'  => $user,
            'posts' => $posts,
            'viewType' => $viewType,
            'tarifList' => $tarifList,
        ]);

    }
    public function actionFaq($city)
    {

        return $this->render('faq');

    }

}
