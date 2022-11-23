<?php

namespace frontend\modules\user\controllers;

use frontend\controllers\BeforeController as Controller;
use frontend\modules\user\models\Posts;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use Yii;

class PublicationController extends Controller
{
    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post'],
                    'start-all' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        if (!$post = Posts::find()
            ->where(['id' => Yii::$app->request->post('id')])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->one()) throw new NotFoundHttpException();

        if (Yii::$app->request->post('key')){

            if (Yii::$app->request->post('key') == 'start'){

                $post->status = Posts::POST_ON_PUPLICATION_STATUS;
                $post->save();

                return Yii::$app->response->content = 'Остановить публикацию';

            }

            if (Yii::$app->request->post('key') == 'stop'){

                $post->status = Posts::POST_DONT_PUBLICATION_STATUS;
                $post->save();

                return Yii::$app->response->content = 'Поставить на публикацию';

            }

        }


        switch ($post->status) {

            case Posts::POST_ON_PUPLICATION_STATUS:

                $post->status = Posts::POST_DONT_PUBLICATION_STATUS;

                $post->save();

                return Yii::$app->response->content = 'Поставить на публикацию';

            case Posts::POST_DONT_PUBLICATION_STATUS:

                $post->status = Posts::POST_ON_PUPLICATION_STATUS;

                $post->save();

                return Yii::$app->response->content = 'Остановить публикацию';

        }

        return Yii::$app->response->content = 'Ошибка';

    }

    public function actionStartAll()
    {

        $type = Yii::$app->request->post('data');

        switch ($type) {
            case 'start':
                $posts = Posts::find()->where(['status' => Posts::POST_DONT_PUBLICATION_STATUS])
                    ->andWhere(['user_id' => Yii::$app->user->id])->all();
                break;
            case 'stop':
                $posts = Posts::find()->where(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                    ->andWhere(['user_id' => Yii::$app->user->id])->all();
                break;
        }

        if ($posts) foreach ($posts as $post) {

            switch ($type) {
                case 'start':
                    $post->status = Posts::POST_ON_PUPLICATION_STATUS;
                    break;
                case 'stop':
                    $post->status = Posts::POST_DONT_PUBLICATION_STATUS;
                    break;
            }

            $post->save();

        }
    }

}