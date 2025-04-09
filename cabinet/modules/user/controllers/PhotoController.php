<?php

namespace cabinet\modules\user\controllers;

use cabinet\modules\user\controllers\CabinetBeforeController as Controller;
use cabinet\models\Files;
use Yii;
use yii\web\NotFoundHttpException;

class PhotoController extends Controller
{
    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionDelete()
    {
        $photoId = \Yii::$app->request->post('id');

        $photo = Files::find()->where(['id' => $photoId])->with('post')->one();

        if ($photo) {

            if ($photo->post->user_id != Yii::$app->user->id) throw new NotFoundHttpException();

            $file = Yii::getAlias('@app/web'.$photo->file);

            if(\is_file($file)) \unlink($file);

            $photo->delete();

        }
    }

}