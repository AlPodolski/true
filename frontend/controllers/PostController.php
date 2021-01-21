<?php


namespace frontend\controllers;

use common\models\City;
use frontend\helpers\RequestHelper;
use frontend\models\Files;
use frontend\modules\user\helpers\ServiceReviewHelper;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionIndex($protocol,$city, $id)
    {
        $post = Posts::find()->where(['id' => $id])
            ->with('allPhoto', 'metro', 'avatar', 'place', 'service',
                'sites', 'rayon', 'nacionalnost',
                'cvet', 'strizhka', 'osobenost', 'selphiCount', 'serviceDesc'
            )
            ->asArray()->one();

        $serviceListReview = ServiceReviewHelper::getPostServiceReview($id);

        $cityInfo = City::getCity($city);

        $backUrl = RequestHelper::getBackUrl($protocol);

        return $this->render('single', [
            'post' => $post,
            'serviceListReview' => $serviceListReview,
            'id' => $id,
            'cityInfo' => $cityInfo,
            'backUrl' => $backUrl,
        ]);

    }

    public function actionMore($city)
    {

        if (Yii::$app->request->isPost){

            $id = \explode(',', Yii::$app->request->post('id'));

            $post = Posts::find()->where(['not in', 'id' , $id])
                ->with('allPhoto', 'metro', 'avatar', 'place', 'service',
                    'sites', 'rayon', 'nacionalnost',
                    'cvet', 'strizhka', 'osobenost', 'selphiCount', 'serviceDesc'
                )
                ->asArray()->one();

            $cityInfo = City::getCity($city);

            $serviceListReview = ServiceReviewHelper::getPostServiceReview($id);

            $price = \frontend\helpers\PostPriceHelper::getMinAndMaxPrice($post['sites']);

            return $this->renderFile(Yii::getAlias('@app/views/post/item.php'), [
                    'post'           => $post,
                'cityInfo'           => $cityInfo,
                 'serviceListReview' => $serviceListReview,
                             'price' => $price
            ]);

        }

        return $this->redirect('/');

    }

    public function actionGet($city)
    {
        if (Yii::$app->request->isPost){

            $params = Yii::$app->request->post();

            switch ($params['target']) {

                case "selfy":

                    $data = Files::find()->where(['related_id' => $params['id'],
                        'type' => Files::SELPHY_TYPE,
                        'related_class' => Posts::class
                        ])
                        ->select('file')
                        ->asArray()->all();

                    break;

                case "video":

                    $data = Posts::find()->where(['id' => $params['id']])->select('video')->asArray()->one();

                    break;

                case "comment-form":

                    $post = Posts::find()->where(['id' => $params['id']])
                        ->with( 'service'
                        )
                        ->asArray()->one();

                    $data['post'] = $post;

                    break;

            }

            return $this->renderFile(Yii::getAlias('@app/views/post/'.$params['target'].'.php'), [
                'data' => $data,
            ]);

        }

        return $this->redirect('/');

    }


}