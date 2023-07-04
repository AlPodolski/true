<?php


namespace frontend\modules\user\controllers;

use common\models\PostMessage;
use frontend\modules\user\models\Posts;
use Yii;
use yii\filters\VerbFilter;
use frontend\modules\user\controllers\CabinetBeforeController as Controller;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class MessageController extends Controller
{
    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'read' => ['POST'],
                ],
            ],
        ];
    }

    public function actionRead($city)
    {
        if ($id = Yii::$app->request->post('id')
            and $message = PostMessage::findOne($id)
            and $post = Posts::findOne($message->post_id)
            and $post->user_id == Yii::$app->user->id
        ){
            $message->status = PostMessage::READ;
            return $message->save();
        }

        return false;

    }
}