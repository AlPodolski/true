<?php


namespace frontend\modules\user\controllers;

use common\models\City;
use common\models\Tarif;
use frontend\models\Files;
use frontend\models\UserMetro;
use frontend\modules\chat\models\relation\UserDialog;
use frontend\modules\user\helpers\SavePostRelationHelper;
use frontend\modules\user\models\forms\AvatarForm;
use frontend\modules\user\models\forms\CheckPhotoForm;
use frontend\modules\user\models\forms\PhotoForm;
use frontend\modules\user\models\forms\SelphiForm;
use frontend\modules\user\models\forms\UpdateAllAvatarForm;
use frontend\modules\user\models\forms\VideoForm;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserOsobenosti;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserService;
use frontend\modules\user\models\UserTime;
use yii\base\BaseObject;
use frontend\modules\user\controllers\CabinetBeforeController as Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
use yii\filters\VerbFilter;

class PostController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'publication' => ['post'],
                    'tarif' => ['post'],
                    'update-photo' => ['post'],
                ],
            ],
        ];
    }

    public function actionAdd($city)
    {
        $post = new Posts();

        $avatarForm = new AvatarForm();
        $photoForm = new PhotoForm();
        $videoForm = new VideoForm();
        $selphiForm = new SelphiForm();

        $checkPhotoForm = new CheckPhotoForm();

        $userMetro = new \frontend\models\UserMetro();
        $userPlace = new \frontend\modules\user\models\UserPlace();
        $userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();
        $userService = new \frontend\modules\user\models\UserService();
        $userTime = new UserTime();

        $city = City::getCity($city);
        $cityList = City::find()->all();

        $post->city_id = $city->id;

        if (Yii::$app->user->identity->status != 10) {
            Yii::$app->session->setFlash('warning', 'Нужно подтвердить почту');
            return $this->redirect('/cabinet/faq');
        }

        if ($post->load(Yii::$app->request->post())
            and $userMetro->load(Yii::$app->request->post())
            and $userPlace->load(Yii::$app->request->post())
            and $userOsobenosti->load(Yii::$app->request->post())
            and $userTime->load(Yii::$app->request->post())
            and $userService->load(Yii::$app->request->post())
        ) {

            $post->user_id = Yii::$app->user->id;
            $post->sort = time();
            $post->fake = Posts::POST_REAL;

            if (!$avatarForm->avatar = UploadedFile::getInstance($avatarForm, 'avatar')) {

                Yii::$app->session->setFlash('warning', 'Нужно добавить фото');

                return $this->redirect('/cabinet/post/add');

            }

            $transaction = Yii::$app->db->beginTransaction();

            if ($post->save()) {

                if ($avatarForm->avatar && $avatarForm->validate()) {

                    $avatar = $avatarForm->upload();

                    if ($avatar) {

                        $file = new Files();

                        $file->related_id = $post['id'];
                        $file->main = Files::MAIN_PHOTO;
                        $file->related_class = Posts::class;
                        $file->file = $avatar;
                        $file->save();

                    }

                } else {

                    $transaction->rollBack();

                    Yii::$app->session->setFlash('warning', 'Попробуйте другое фото');

                    return $this->redirect('/cabinet/post/add');

                }

                $checkPhotoForm->file = UploadedFile::getInstance($checkPhotoForm, 'file');

                if ($checkPhotoForm->file and $checkPhotoForm->validate()) {

                    $checkPhoto = $checkPhotoForm->upload();

                    $file = new Files();

                    $file->related_id = $post['id'];
                    $file->main = Files::NOT_MAIN_PHOTO;
                    $file->type = Files::CHECK_PHOTO_TYPE;
                    $file->related_class = Posts::class;
                    $file->file = $checkPhoto;
                    $file->save();

                }

                $videoForm->video = UploadedFile::getInstance($videoForm, 'video');

                if ($videoForm->video && $videoForm->validate()) {

                    $video = $videoForm->upload();

                    if ($video) {

                        $post->video = $video;

                        $post->save();

                    }

                }

                $photoForm->photo = UploadedFile::getInstances($photoForm, 'photo');

                $selphiForm->photo = UploadedFile::getInstances($selphiForm, 'photo');

                if ($photoForm->photo && $photoForm->validate()) {

                    $gallery = $photoForm->upload();

                    foreach ($gallery as $item) {

                        $file = new Files();

                        $file->related_id = $post['id'];
                        $file->main = Files::NOT_MAIN_PHOTO;
                        $file->related_class = Posts::class;
                        $file->file = $item;
                        $file->save();

                    }

                }

                if ($selphiForm->photo && $selphiForm->validate()) {

                    $gallery = $selphiForm->upload();

                    foreach ($gallery as $item) {

                        $file = new Files();

                        $file->related_id = $post['id'];
                        $file->main = Files::NOT_MAIN_PHOTO;
                        $file->related_class = Posts::class;
                        $file->type = Files::SELPHY_TYPE;
                        $file->file = $item;
                        $file->save();

                    }

                }

                if ($userMetro['metro_id']) {

                    $userMetro->validate();

                    SavePostRelationHelper::save(UserMetro::class,
                        $userMetro['metro_id'],
                        $post['id'],
                        'metro_id', $post['city_id']);

                }


                if ($userPlace['place_id'])
                    SavePostRelationHelper::save(UserPlace::class,
                        $userPlace['place_id'],
                        $post['id'],
                        'place_id', $post['city_id']);

                if ($userOsobenosti['param_id'])
                    SavePostRelationHelper::save(UserOsobenosti::class,
                        $userOsobenosti['param_id'],
                        $post['id'],
                        'param_id', $post['city_id']);

                if ($userTime['param_id'])
                    SavePostRelationHelper::save(UserTime::class,
                        $userTime['param_id'],
                        $post['id'],
                        'param_id', $post['city_id']);

                if ($userService['service_id'])
                    SavePostRelationHelper::saveService($post['id'],
                        $userService, $post['city_id']);

                $transaction->commit();

                if (isset($_POST['add-more'])){

                    return $this->render('add',
                        [
                            'post' => $post,
                            'city' => $city,
                            'cityList' => $cityList,
                            'add_more' => true,
                        ]
                    );

                }

                return $this->redirect('/cabinet');

            }

        }

        return $this->render('add', [
            'post' => $post,
            'city' => $city,
            'cityList' => $cityList,
            'add_more' => true,
        ]);
    }

    public function actionEdit($id, $city)
    {

        $city = City::getCity($city);

        $cityList = City::find()->all();

        $post = Posts::find()->where(['id' => $id])->with('avatar', 'gal', 'selphiCount')->one();

        if (!$post or $post['user_id'] != Yii::$app->user->id) {

            Yii::$app->session->addFlash('warning', 'Отказано в доступе');

            return $this->redirect('/cabinet');

        }

        $avatarForm = new AvatarForm();

        $videoForm = new VideoForm();

        $photoForm = new PhotoForm();

        $selphiForm = new SelphiForm();

        $checkPhotoForm = new CheckPhotoForm();

        $userMetro = new UserMetro();
        $userPlace = new UserPlace();
        $userOsobenosti = new UserOsobenosti();
        $userService = new UserService();
        $userTime = new UserTime();

        if ($post->load(Yii::$app->request->post())
            and $userMetro->load(Yii::$app->request->post())
            and $userPlace->load(Yii::$app->request->post())
            and $userOsobenosti->load(Yii::$app->request->post())
            and $userTime->load(Yii::$app->request->post())
            and $userService->load(Yii::$app->request->post())) {
            if ($post->save()) {

                Yii::$app->cache->delete('post_cache_' . $post->id . '_' . $post->city_id);

                $avatarForm->avatar = UploadedFile::getInstance($avatarForm, 'avatar');

                if ($avatarForm->avatar && $avatarForm->validate()) {

                    $avatar = $avatarForm->upload();

                    if ($avatar) {

                        Files::updateAll(['main' => Files::NOT_MAIN_PHOTO], ['related_id' => $post->id,
                            'related_class' => Posts::class]);

                        $file = new Files();

                        $file->related_id = $post['id'];
                        $file->main = Files::MAIN_PHOTO;
                        $file->related_class = Posts::class;
                        $file->file = $avatar;
                        $file->save();

                    }

                }

                $videoForm->video = UploadedFile::getInstance($videoForm, 'video');

                if ($videoForm->video && $videoForm->validate()) {

                    $video = $videoForm->upload();

                    if ($video) {

                        if ($post['video']) {

                            \unlink(Yii::getAlias("@app/web" . $post['video']));

                        }

                        $post->video = $video;

                        $post->save();

                    }

                }

                $photoForm->photo = UploadedFile::getInstances($photoForm, 'photo');

                $selphiForm->photo = UploadedFile::getInstances($selphiForm, 'photo');

                $checkPhotoForm->file = UploadedFile::getInstance($checkPhotoForm, 'file');

                if ($checkPhotoForm->file and $checkPhotoForm->validate()) {

                    $checkPhoto = $checkPhotoForm->upload();

                    $oldCheckPhoto = Files::findOne(
                        ['type' => Files::CHECK_PHOTO_TYPE, 'related_id' => $post['id'], 'related_class' => Posts::class]);

                    if ($oldCheckPhoto) {

                        if ($oldCheckPhoto['file']) {

                            \unlink(Yii::getAlias("@app/web" . $oldCheckPhoto['file']));

                            $oldCheckPhoto->delete();

                        }

                    }

                    $file = new Files();

                    $file->related_id = $post['id'];
                    $file->main = Files::NOT_MAIN_PHOTO;
                    $file->type = Files::CHECK_PHOTO_TYPE;
                    $file->related_class = Posts::class;
                    $file->file = $checkPhoto;
                    $file->save();

                }

                if ($photoForm->photo && $photoForm->validate()) {

                    $gallery = $photoForm->upload();

                    foreach ($gallery as $item) {

                        $file = new Files();

                        $file->related_id = $post['id'];
                        $file->main = Files::NOT_MAIN_PHOTO;
                        $file->related_class = Posts::class;
                        $file->file = $item;
                        $file->save();

                    }

                }

                if ($selphiForm->photo && $selphiForm->validate()) {

                    $gallery = $selphiForm->upload();

                    foreach ($gallery as $item) {

                        $file = new Files();

                        $file->related_id = $post['id'];
                        $file->main = Files::NOT_MAIN_PHOTO;
                        $file->related_class = Posts::class;
                        $file->type = Files::SELPHY_TYPE;
                        $file->file = $item;
                        $file->save();

                    }

                }

                if ($userMetro['metro_id']) {
                    $userMetro->validate();
                    SavePostRelationHelper::save(UserMetro::class,
                        $userMetro['metro_id'],
                        $post['id'],
                        'metro_id', $post['city_id']);
                }


                if ($userPlace['place_id'])
                    SavePostRelationHelper::save(UserPlace::class,
                        $userPlace['place_id'],
                        $post['id'],
                        'place_id', $post['city_id']);

                if ($userOsobenosti['param_id'])
                    SavePostRelationHelper::save(UserOsobenosti::class,
                        $userOsobenosti['param_id'],
                        $post['id'],
                        'param_id', $post['city_id']);

                if ($userTime['param_id'])
                    SavePostRelationHelper::save(UserTime::class,
                        $userTime['param_id'],
                        $post['id'],
                        'param_id', $post['city_id']);

                if ($userService['service_id'])
                    SavePostRelationHelper::saveService($post['id'],
                        $userService, $post['city_id']);

                Yii::$app->session->setFlash('success', 'Данные анкеты ' . $post['name'] . ' сохранены');

                return $this->redirect('/cabinet');

            }

        }

        return $this->render('edit', [
            'post' => $post,
            'city' => $city,
            'cityList' => $cityList,
        ]);

    }

    public function actionDelete($city)
    {
        $id = Yii::$app->request->post('id');

        if ($post = Posts::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) {

            if ($postPhoto = Files::findAll(['related_id' => $post['id'], 'related_class' => Posts::class])) {

                foreach ($postPhoto as $item) {

                    $file = Yii::getAlias('@app/web' . $item->file);

                    if (\is_file($file)) \unlink($file);

                    $item->delete();

                }

            }

            UserMetro::deleteAll(['post_id' => $post['id']]);
            UserPLace::deleteAll(['post_id' => $post['id']]);
            UserService::deleteAll(['post_id' => $post['id']]);

            $post->delete();

        }
    }

    public function actionTarif()
    {
        $postId = Yii::$app->request->post('id');
        $tarifId = Yii::$app->request->post('tarif_id');
        $userId = Yii::$app->user->id;

        $post = Posts::find()->where(['id' => $postId])->andWhere(['user_id' => $userId])->one();
        $tarif = Tarif::findOne(['id' => $tarifId]);

        if ($post and $tarif) {

            $post->tarif_id = $tarif->id;
            $post->save();

            return true;

        }

        throw new NotFoundHttpException();

    }
    public function actionTarifAll()
    {
        $postId = Yii::$app->request->post('ids');

        $tarifId = Yii::$app->request->post('tarif');

        $userId = Yii::$app->user->id;

        $posts = Posts::find()->where(['in', 'id', $postId])
            ->andWhere(['user_id' => $userId])->all();

        $tarif = Tarif::findOne(['id' => $tarifId]);

        if ($posts){

            foreach ($posts as $post){

                $post->tarif_id = $tarif->id;
                $post->save();

            }

            return true;

        }

        throw new NotFoundHttpException();

    }

    public function actionUpdatePhoto()
    {
        $model = new AvatarForm();

        $data = Yii::$app->request->post('AvatarForm');

        if ($data and $model->avatar = UploadedFile::getInstance($model, 'avatar')) {

            $post = Posts::find()->where(['id' => $data['post_id'], 'user_id' => Yii::$app->user->id])->with('avatar')->one();

            if ($post) {

                $file = Yii::getAlias('@app/web' . $post->avatar->file);

                if (\is_file($file)) \unlink($file);

                $tempFile = $model->upload();

                $post->avatar->file = $tempFile;

                $post->avatar->save();

                return Yii::$app->imageCache->thumbSrc($tempFile, '100_100');

            }

        }
    }
    public function actionUpdatePhotoAll()
    {
        $model = new UpdateAllAvatarForm();

        $data = Yii::$app->request->post('UpdateAllAvatarForm');

        if ($data and $model->photo = UploadedFile::getInstance($model, 'photo')) {

            $ids = explode(',', $data['ids']);

            $posts = Posts::find()->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['in', 'id', $ids])
                ->with('avatar')
                ->all();

            $tempFile = $model->upload();

            foreach ($posts as $post){

                $file = Yii::getAlias('@app/web' . $post->avatar->file);

                if (\is_file($file)) \unlink($file);

                if ($post->avatar->file){

                    $post->avatar->file = $tempFile;

                    $post->avatar->save();

                }

            }

            return Yii::$app->imageCache->thumbSrc($tempFile, '100_100');

        }
    }
}