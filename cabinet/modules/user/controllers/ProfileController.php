<?php


namespace cabinet\modules\user\controllers;

use common\models\User;
use cabinet\helpers\FileHelper;
use cabinet\models\Files;
use cabinet\modules\user\models\forms\EditProfileForm;
use cabinet\modules\user\models\Posts;
use Yii;
use cabinet\modules\user\controllers\CabinetBeforeController as Controller;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionEdit($city)
    {

        $user = User::find()->where(['id' => Yii::$app->user->id])->with('avatar')->one();

        $editProfileForm = new EditProfileForm();

        $editProfileForm->user_id = $user['id'];

        if ($editProfileForm->load(Yii::$app->request->post()) and $editProfileForm->save()){

            if ($photo = UploadedFile::getInstance($editProfileForm, 'avatar') and $photoSrc = FileHelper::savePhoto($photo->tempName, 'jpg')){

                if ($file = Files::find()->where(['related_id' => $user['id'], 'related_class' => User::class])->one()){

                    \unlink(Yii::getAlias('@cabinet/web'.$file['file']));

                    $file->file = $photoSrc;

                    $file->save();

                }

                else{

                    $file = new Files();

                    $file->related_id = $user['id'];
                    $file->main = Files::MAIN_PHOTO;
                    $file->related_class = User::class;
                    $file->file = $photoSrc;
                    $file->save();

                }

            }

        }

        if (Yii::$app->request->isPost){

            return $this->redirect('/cabinet');

        }

        $editProfileForm->username = $user->username;
        $editProfileForm->age = $user->age;
        $editProfileForm->male = $user->male;
        $editProfileForm->notify = $user->notify;
        $editProfileForm->open_message = $user->open_message;

        return $this->render('edit', [
            'user' => $user,
            'model' => $editProfileForm
        ]);
    }

}