<?php


namespace frontend\controllers;

use common\jobs\AddViewJob;
use common\models\City;
use common\models\Service;
use common\models\User;
use frontend\components\helpers\AddViewHelper;
use frontend\helpers\GetCommentByPhoneHelper;
use frontend\helpers\GetPostHelper;
use frontend\helpers\RequestHelper;
use frontend\helpers\shema\SingleProductShema;
use frontend\models\Files;
use frontend\models\forms\AnketClaimForm;
use frontend\models\forms\GetCallForm;
use frontend\models\forms\PhoneReviewForm;
use frontend\modules\chat\models\relation\UserDialog;
use frontend\modules\user\helpers\ServiceReviewHelper;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\Profile;
use frontend\repository\PostsRepository;
use Yii;
use yii\helpers\ArrayHelper;
use frontend\controllers\BeforeController as Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{

    public function behaviors()
    {
        if (Yii::$app->user->isGuest) return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600 * 2,
                'variations' => [
                    Yii::$app->request->url
                ],
            ],
        ];

    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex($protocol, $city, $id)
    {

        $cityInfo = City::getCity($city);

        if (!$cityInfo) {
            http_response_code(502);
            exit();
        };

        $post = GetPostHelper::getForSingle($id, $cityInfo['id']);

        if ($post) {

            $productShema = (new SingleProductShema($post))->make();

            $viewPostsIds = (new AddViewHelper())->add($post['id']);

            $viewPosts = (new PostsRepository())->getByIdPosts($viewPostsIds, 30);

            $recomendPost = GetPostHelper::getRecomend($cityInfo['id']);

            //$serviceListReview = ServiceReviewHelper::getPostServiceReview($id);
            $serviceListReview = false;

            $backUrl = RequestHelper::getBackUrl($protocol);

            $refererCategory = RequestHelper::getRefererCategory($protocol);

            //redis_post_single_view_count_key

            Yii::$app->queueView->push(new AddViewJob([
                'posts' => $post,
                'type' => 'redis_post_single_view_count_key',
            ]));

            //$postsByPhone = GetPostHelper::getByPhone($post['phone'], $cityInfo['id']);

            $postsByPhone = false;

            if ($post['phone']) $phoneComments = (new GetCommentByPhoneHelper($post['phone']))->get();

            $serviceList = Service::find()->cache(3600 * 24)->all();

            return $this->render('single', [
                'post' => $post,
                'serviceListReview' => $serviceListReview,
                'cityInfo' => $cityInfo,
                'viewPosts' => $viewPosts,
                'productShema' => $productShema,
                'phoneComments' => $phoneComments,
                'postsByPhone' => $postsByPhone,
                'backUrl' => $backUrl,
                'refererCategory' => $refererCategory,
                'serviceList' => $serviceList,
                'recomendPost' => $recomendPost,
                'first' => true
            ]);

        }

        throw new NotFoundHttpException();

    }

    public function actionMore($city)
    {

        $this->enableCsrfValidation = false;

        if (Yii::$app->request->isPost) {

            $id = \explode(',', Yii::$app->request->post('id'));
            $price = Yii::$app->request->post('price');
            $pol = Yii::$app->request->post('pol');
            $ref = Yii::$app->request->post('ref');

            $cityInfo = City::getCity($city);

            $postRepository = new PostsRepository($cityInfo['id']);

            $post = $postRepository->getPostForMoreSingle($id, $price, $pol, $ref);

            if ($post) {

                Yii::$app->queueView->push(new AddViewJob([
                    'posts' => $post,
                    'type' => 'redis_post_single_view_count_key',
                ]));

                $serviceListReview = false;

                $price = \frontend\helpers\PostPriceHelper::getMinAndMaxPrice($post['sites']);

                $moreText = $post['name'];

                return $this->renderFile(Yii::getAlias('@app/views/post/item.php'), [
                    'post' => $post,
                    'cityInfo' => $cityInfo,
                    'serviceListReview' => $serviceListReview,
                    'price' => $price,
                    'moreText' => $moreText,
                ]);

            }

        } else return $this->redirect('/');

    }

    public function actionGet($city)
    {
        if (Yii::$app->request->isPost) {

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

                    if (!Yii::$app->user->isGuest) {

                        $userToId = Yii::$app->request->post('id');

                        if ($userToId) {

                            $userTo = User::find()
                                ->where(['id' => $userToId])
                                ->with('avatar')
                                ->asArray()
                                ->one();

                            if ($userTo['open_message'] == User::MESSAGE_ALLOWED) {

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

                            } else {

                                return $this->renderFile(Yii::getAlias('@frontend/views/layouts/message.php'),
                                    [
                                        'message' => 'Пользователь ограничил получение сообщений'
                                    ]
                                );

                            }


                        } else {

                            return $this->renderFile(Yii::getAlias('@frontend/views/layouts/message.php'),
                                [
                                    'message' => 'Пользователь ограничил получение сообщений'
                                ]
                            );

                        }

                    } else {

                        return $this->renderFile(Yii::getAlias('@frontend/views/layouts/authorisation.php'));

                    }

                case "comment-form":

                    $post = Posts::find()->where(['id' => $params['id']])
                        ->with('service')
                        ->asArray()
                        ->one();

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

            return $this->renderFile(Yii::getAlias('@app/views/post/' . $params['target'] . '.php'), [
                'data' => $data,
            ]);

        }

        return $this->redirect('/');

    }


}