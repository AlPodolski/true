<?php


namespace frontend\modules\user\controllers;

use common\models\City;
use frontend\models\Files;
use frontend\models\UserMetro;
use frontend\modules\user\helpers\SavePostRelationHelper;
use frontend\modules\user\models\forms\AvatarForm;
use frontend\modules\user\models\forms\PhotoForm;
use frontend\modules\user\models\forms\VideoForm;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserOsobenosti;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserRayon;
use frontend\modules\user\models\UserService;
use yii\web\Controller;
use yii\web\UploadedFile;
use Yii;

class PostController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionAdd($city)
    {
        $post = new Posts();

        $avatarForm = new AvatarForm();
        $photoForm = new PhotoForm();
        $videoForm = new VideoForm();

        $userNational = new \frontend\modules\user\models\UserNational();
        $userMetro = new \frontend\models\UserMetro();
        $userPlace = new \frontend\modules\user\models\UserPlace();
        $userHairColor = new \frontend\modules\user\models\UserHairColor();
        $userIntimHair = new \frontend\modules\user\models\UserIntimHair();
        $userRayon = new \frontend\modules\user\models\UserRayon();
        $userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();
        $userService = new \frontend\modules\user\models\UserService();

        $city = City::getCity($city);

        if ($post->load(Yii::$app->request->post())
            and $userNational->load(Yii::$app->request->post())
            and $userMetro->load(Yii::$app->request->post())
            and $userPlace->load(Yii::$app->request->post())
            and $userHairColor->load(Yii::$app->request->post())
            and $userIntimHair->load(Yii::$app->request->post())
            and $userRayon->load(Yii::$app->request->post())
            and $userOsobenosti->load(Yii::$app->request->post())
            and $userService->load(Yii::$app->request->post())
        ){

            $post->user_id = Yii::$app->user->id;

            $post->city_id = $city['id'];

            $post->created_at = $time = \time();

            $post->updated_at = $time;

            if ($post->save()){

                $avatarForm->avatar = UploadedFile::getInstance($avatarForm, 'avatar');

                if ($avatarForm->avatar && $avatarForm->validate()) {

                    $avatar = $avatarForm->upload();

                    if ($avatar){

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

                    if ($video){

                        $post->video = $video;

                        $post->save();

                    }

                }

                $photoForm->photo = UploadedFile::getInstances($photoForm, 'photo');

                if ($photoForm->photo && $photoForm->validate()) {

                    $gallery = $photoForm->upload();

                    foreach($gallery as $item){

                        $file = new Files();

                        $file->related_id = $post['id'];
                        $file->main = Files::NOT_MAIN_PHOTO;
                        $file->related_class = Posts::class;
                        $file->file = $item;
                        $file->save();

                    }

                }

                if ($userNational['national_id'])
                    SavePostRelationHelper::save(UserNational::class,
                    $userNational->national_id,
                    $post['id'],
                    'national_id', $city['id']
                );

                if ($userMetro['metro_id'])
                    SavePostRelationHelper::save(UserMetro::class,
                        $userMetro['metro_id'],
                        $post['id'],
                        'metro_id', $city['id']);

                if ($userPlace['place_id'])
                    SavePostRelationHelper::save(UserPlace::class,
                        $userPlace['place_id'],
                        $post['id'],
                        'place_id', $city['id']);

                if ($userHairColor['hair_color_id'])
                    SavePostRelationHelper::save(UserHairColor::class,
                        $userHairColor['hair_color_id'],
                        $post['id'],
                        'hair_color_id', $city['id']);

                if ($userIntimHair['color_id'])
                    SavePostRelationHelper::save(UserIntimHair::class,
                        $userIntimHair['color_id'],
                        $post['id'],
                        'color_id', $city['id']);

                if ($userRayon['rayon_id'])
                    SavePostRelationHelper::save(UserRayon::class,
                        $userRayon['rayon_id'],
                        $post['id'],
                        'rayon_id', $city['id']);

                if ($userOsobenosti['param_id'])
                    SavePostRelationHelper::save(UserOsobenosti::class,
                        $userOsobenosti['param_id'],
                        $post['id'],
                        'param_id', $city['id']);

                if ($userService['service_id'])
                    SavePostRelationHelper::save(UserService::class,
                        $userService['service_id'],
                        $post['id'],
                        'service_id', $city['id']);

                return $this->redirect('/cabinet');

            }

        }

        return $this->render('add', [
            'post' => $post,
            'city' => $city,
        ]);
    }

    public function actionEdit($id, $city)
    {

        $city = City::getCity($city);

        $post = Posts::find()->where(['id' => $id])->with('avatar', 'gal')->one();

        if (!$post or $post['user_id'] != Yii::$app->user->id) {

            Yii::$app->session->addFlash('warning' , 'Отказано в доступе');

            return $this->redirect('/cabinet');

        }

        $avatarForm = new AvatarForm();

        $videoForm = new VideoForm();

        $photoForm = new PhotoForm();

        $userNational = new UserNational();
        $userMetro = new UserMetro();
        $userPlace = new UserPlace();
        $userHairColor = new UserHairColor();
        $userIntimHair = new UserIntimHair();
        $userRayon = new UserRayon();
        $userOsobenosti = new UserOsobenosti();
        $userService = new UserService();

        if ($post->load(Yii::$app->request->post())
            and $userNational->load(Yii::$app->request->post())
            and $userMetro->load(Yii::$app->request->post())
            and $userPlace->load(Yii::$app->request->post())
            and $userHairColor->load(Yii::$app->request->post())
            and $userIntimHair->load(Yii::$app->request->post())
            and $userRayon->load(Yii::$app->request->post())
            and $userOsobenosti->load(Yii::$app->request->post())
            and $userService->load(Yii::$app->request->post())){

            if ($post->save()){

            $avatarForm->avatar = UploadedFile::getInstance($avatarForm, 'avatar');

            if ($avatarForm->avatar && $avatarForm->validate()) {

                $avatar = $avatarForm->upload();

                if ($avatar){

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

                if ($video){

                    if ($post['video']){

                        \unlink(Yii::getAlias("@app/web".$post['video']));

                    }

                    $post->video = $video;

                    $post->save();

                }

            }

            $photoForm->photo = UploadedFile::getInstances($photoForm, 'photo');

            if ($photoForm->photo && $photoForm->validate()) {

                $gallery = $photoForm->upload();

                foreach($gallery as $item){

                    $file = new Files();

                    $file->related_id = $post['id'];
                    $file->main = Files::NOT_MAIN_PHOTO;
                    $file->related_class = Posts::class;
                    $file->file = $item;
                    $file->save();

                }

            }

            if ($userNational['national_id'])
                SavePostRelationHelper::save(UserNational::class,
                    $userNational->national_id,
                    $post['id'],
                    'national_id', $city['id']
                );

            if ($userMetro['metro_id'])
                SavePostRelationHelper::save(UserMetro::class,
                    $userMetro['metro_id'],
                    $post['id'],
                    'metro_id', $city['id']);

            if ($userPlace['place_id'])
                SavePostRelationHelper::save(UserPlace::class,
                    $userPlace['place_id'],
                    $post['id'],
                    'place_id', $city['id']);

            if ($userHairColor['hair_color_id'])
                SavePostRelationHelper::save(UserHairColor::class,
                    $userHairColor['hair_color_id'],
                    $post['id'],
                    'hair_color_id', $city['id']);

            if ($userIntimHair['color_id'])
                SavePostRelationHelper::save(UserIntimHair::class,
                    $userIntimHair['color_id'],
                    $post['id'],
                    'color_id', $city['id']);

            if ($userRayon['rayon_id'])
                SavePostRelationHelper::save(UserRayon::class,
                    $userRayon['rayon_id'],
                    $post['id'],
                    'rayon_id', $city['id']);

            if ($userOsobenosti['param_id'])
                SavePostRelationHelper::save(UserOsobenosti::class,
                    $userOsobenosti['param_id'],
                    $post['id'],
                    'param_id', $city['id']);

            if ($userService['service_id'])
                SavePostRelationHelper::save(UserService::class,
                    $userService['service_id'],
                    $post['id'],
                    'service_id', $city['id']);

            Yii::$app->session->setFlash('success' , 'Данные анкеты '.$post['name'].' сохранены');

            return $this->redirect('/cabinet');

            }

        }

        $city = City::getCity($city);

        return $this->render('edit' , [
            'post' => $post,
            'city' => $city,
        ]);

    }
}