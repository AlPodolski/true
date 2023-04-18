<?php

namespace backend\controllers;

use common\models\City;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;

class ApiController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionPost()
    {

        $city = Yii::$app->request->post('city');

        $cityInfo = City::find()->where(['id' => $city])->one();

        if ($cityInfo) {

            $post = Posts::find()->where([
                'status' => Posts::POST_ON_PUPLICATION_STATUS,
                'city_id' => $cityInfo['id']
            ])
                ->orderBy('rand()')
                ->with('avatar')
                ->one();

            if ($post and isset($post->avatar->file)) {

                $file = $post->avatar->file;

                if ($file) {

                    $result = [
                        'name' => $post->name,
                        'url' => 'https://' . $cityInfo['url'] . '.' . Yii::$app->params['domain'] . '/post/' . $post['id'],
                        'photo' => 'https://' . $cityInfo['url'] . '.' . Yii::$app->params['domain'] . Yii::$app->imageCache->thumbSrc($file, '500_700')
                    ];

                    return json_encode($result);

                }

            }

        }

        return '';

    }

}