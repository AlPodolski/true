<?php


namespace console\controllers;

use backend\models\Posts;
use frontend\modules\user\models\PostSites;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;
use common\models\User;

class CustController extends Controller
{
    public function actionIndex()
    {
        $posts = Posts::findAll(['user_id' => null]);

        foreach ($posts as $post){

            if (PostSites::find()->where(['post_id' => $post->id])->count() == 1 ){

                $user = new User();
                $user->username = $post->name;
                $user->email = 'admin@mail.com';
                $user->city_id = $post['city_id'];
                $user->setPassword(Yii::$app->security->generateRandomString(10));
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
                if ($user->save()) {

                    $post->user_id = $user->id;

                    $post->save();

                }

            }

        }

    }
}