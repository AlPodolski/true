<?php

namespace frontend\modules\user\controllers;

use frontend\modules\user\models\Posts;
use Yii;

class CabinetController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }


    public function actionIndex($city)
    {

        $user = Yii::$app->user->identity;

        $posts = Posts::find()->where(['user_id' => Yii::$app->user->id])->with('avatar')->all();

        return $this->render('index', [
            'user'  => $user,
            'posts' => $posts,
        ]);

    }

}
