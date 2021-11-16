<?php


namespace frontend\controllers;

use common\models\City;
use common\models\User;
use frontend\helpers\RequestHelper;
use frontend\models\Files;
use frontend\models\forms\AnketClaimForm;
use frontend\models\forms\GetCallForm;
use frontend\models\forms\PhoneReviewForm;
use frontend\modules\chat\models\relation\UserDialog;
use frontend\modules\user\helpers\ServiceReviewHelper;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\Profile;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex($protocol,$city, $id)
    {

        $post = Posts::find()->where(['id' => $id])
            ->with('gal', 'metro', 'avatar', 'place', 'service',
                'sites', 'rayon', 'nacionalnost',
                'cvet', 'strizhka', 'osobenost', 'selphiCount', 'serviceDesc', 'partnerId'
            )
            ->asArray()->limit(1)->one();

        if ($post){

            $serviceListReview = ServiceReviewHelper::getPostServiceReview($id);

            $cityInfo = City::find()->where(['id' => $post['city_id']])->one();

            $backUrl = RequestHelper::getBackUrl($protocol);

            ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_single_view_count_key']);

            return $this->render('single', [
                'post' => $post,
                'serviceListReview' => $serviceListReview,
                'id' => $id,
                'cityInfo' => $cityInfo,
                'backUrl' => $backUrl,
            ]);

        }

        throw new NotFoundHttpException();

    }

    public function actionMore($city)
    {

        $this->enableCsrfValidation = false;

        if (Yii::$app->request->isPost){

            $id = \explode(',', Yii::$app->request->post('id'));

            $cityInfo = City::getCity($city);

            $post = Posts::find()->where(['not in', 'id' , $id])
                ->with('gal', 'metro', 'avatar', 'place', 'service',
                    'sites', 'rayon', 'nacionalnost',
                    'cvet', 'strizhka', 'osobenost', 'selphiCount', 'serviceDesc', 'partnerId')
                ->andWhere(['city_id' => $cityInfo['id']])
                ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                ->orderBy(['rand()' => SORT_DESC])
                ->asArray()
                ->one();

            if ($post){

                $serviceListReview = ServiceReviewHelper::getPostServiceReview($post['id']);

                $price = \frontend\helpers\PostPriceHelper::getMinAndMaxPrice($post['sites']);

                ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']);
                ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_single_view_count_key']);

                return $this->renderFile(Yii::getAlias('@app/views/post/item.php'), [
                    'post'           => $post,
                    'cityInfo'           => $cityInfo,
                    'serviceListReview' => $serviceListReview,
                    'price' => $price
                ]);

            }

        }else return $this->redirect('/');

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

                case "message":

                    if (!Yii::$app->user->isGuest){

                        $userToId = Yii::$app->request->post('id');

                        if ($userToId){

                            $userTo = User::find()
                                ->where(['id' => $userToId])
                                ->with('avatar')
                                ->asArray()
                                ->one();

                            if ($userTo['open_message'] == User::MESSAGE_ALLOWED){

                                $userDialogsId = ArrayHelper::getColumn(UserDialog::find()
                                    ->where(['user_id' => Yii::$app->user->id])->asArray()->all(), 'dialog_id');

                                $dialog_id = UserDialog::find()->where(['user_id' => Yii::$app->request->post('id')])
                                    ->andWhere(['in', 'dialog_id', $userDialogsId])->asArray()->one();

                                $user = User::find()->where(['id' => Yii::$app->user->id])
                                    ->with('avatar')
                                    ->asArray()->one();


                                return $this->renderFile(Yii::getAlias('@frontend/modules/chat/views/chat/get-dialog.php'), [
                                    'dialog_id' => $dialog_id,
                                    'user' => $user,
                                    'userTo' => $userTo,
                                    'recepient' => Yii::$app->request->post('id'),
                                ]);

                            }else{

                                return $this->renderFile(Yii::getAlias('@frontend/views/layouts/message.php'),
                                    [
                                        'message' => 'Пользователь ограничил получение сообщений'
                                    ]
                                );

                            }



                        }else{

                            return $this->renderFile(Yii::getAlias('@frontend/views/layouts/message.php'),
                                [
                                    'message' => 'Пользователь ограничил получение сообщений'
                                ]
                            );

                        }

                    }else{

                        return $this->renderFile(Yii::getAlias('@frontend/views/layouts/authorisation.php'));

                    }

                case "comment-form":

                    $post = Posts::find()->where(['id' => $params['id']])
                        ->with( 'service'
                        )
                        ->asArray()->one();

                    $data['post'] = $post;

                    break;

                case "claim":

                    $data['claim'] = new AnketClaimForm();

                    $data['id'] = $params['id'];

                    break;

                case "call":

                    $data['call'] = new GetCallForm();

                    $data['id'] = $params['id'];

                    break;

                case "phone-claim-form":

                    $data = $params;

                    $data['model'] = new PhoneReviewForm();

                    break;

            }

            return $this->renderFile(Yii::getAlias('@app/views/post/'.$params['target'].'.php'), [
                'data' => $data,
            ]);

        }

        return $this->redirect('/');

    }


}