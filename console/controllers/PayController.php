<?php

namespace console\controllers;

use frontend\modules\user\models\Posts;

class PayController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $posts = Posts::find()->where(['']);
    }
}