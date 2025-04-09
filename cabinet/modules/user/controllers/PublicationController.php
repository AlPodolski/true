<?php

namespace cabinet\modules\user\controllers;

use cabinet\modules\user\controllers\CabinetBeforeController as Controller;
use cabinet\modules\user\models\Posts;
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
            ->with('tarif')
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->one()) throw new NotFoundHttpException();

        if (Yii::$app->request->post('key')) {

            if (Yii::$app->request->post('key') == 'start') {

                if ($post->pay_time < time()) {

                    if ($post->tarif->sum > Yii::$app->user->identity->cash) return 'Недостаточно средств';

                }

                $post->status = Posts::POST_ON_PUPLICATION_STATUS;
                $post->save();

                return Yii::$app->response->content = 'Остановить публикацию';

            }

            if (Yii::$app->request->post('key') == 'stop') {

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

                if ($post->pay_time < time()) {

                    if ($post->tarif->sum > Yii::$app->user->identity->cash) return 'Недостаточно средств';

                }

                $post->status = Posts::POST_ON_PUPLICATION_STATUS;

                $post->save();

                return Yii::$app->response->content = 'Остановить публикацию';

        }

        return Yii::$app->response->content = 'Ошибка';

    }

    public function actionStartAll()
    {

        if (Yii::$app->user->isGuest) return false;

        $type = Yii::$app->request->post('data');

        $data = Yii::$app->cache->get('rate_limit_' . Yii::$app->user->id);

        if ($data === false) {

            switch ($type) {
                case 'start':
                    $posts = Posts::find()->where(['status' => Posts::POST_DONT_PUBLICATION_STATUS])
                        ->with('tarif')
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

                        if ($post->pay_time < time()) {

                            if ($post->tarif->sum > Yii::$app->user->identity->cash) return 'Недостаточно средств';

                        }

                        $post->status = Posts::POST_ON_PUPLICATION_STATUS;
                        break;
                    case 'stop':
                        $post->status = Posts::POST_DONT_PUBLICATION_STATUS;
                        break;
                }

                $post->save();

            }

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('rate_limit_' . Yii::$app->user->id, 1, 60);

        }

    }

}