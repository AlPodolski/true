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

        $cityInfo = City::find()->where(['id' => $city])->cache(3600)->one();

        if ($cityInfo) {

            $post = Posts::find()->where([
                'status' => Posts::POST_ON_PUPLICATION_STATUS,
                'city_id' => $cityInfo['id'],
                'fake' => Posts::POST_REAL,
                'pol_id' => 1,
            ])
                ->orderBy('rand()')
                ->with('avatar')
                ->one();

            if (!$post){
                $post = Posts::find()->where([
                    'status' => Posts::POST_ON_PUPLICATION_STATUS,
                    'city_id' => $cityInfo['id']
                ])
                    ->orderBy('rand()')
                    ->with('avatar')
                    ->one();
            }

            if ($post and isset($post->avatar->file)) {

                $file = $post->avatar->file;

                if ($file) {

                    $cityUrl = $cityInfo['url'];

                    if ($cityInfo['actual_city']) $cityUrl = $cityInfo['actual_city'];

                    $result = [
                        'name' => $post->name,
                        'age' => $post->age,
                        'url' => 'https://' . $cityUrl . '.' . Yii::$app->params['domain'] . '/post/' . $post['id'],
                        'photo' => 'https://' . $cityUrl . '.' . Yii::$app->params['domain'] . Yii::$app->imageCache->thumbSrc($file, '500_700')
                    ];

                    return json_encode($result);

                }

            }

        }

        return '';

    }

    public function actionCity()
    {
        $city = Yii::$app->request->post('city');

        if ($cityInfo = City::find()->where(['id' => $city])->cache(3600)->one()){

            $result = [
                'url' => 'https://' . $cityInfo->actual_city . '.' . Yii::$app->params['domain'],
            ];

            return json_encode($result);

        }


    }

}