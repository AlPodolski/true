<?php


namespace frontend\modules\user\controllers;

use common\models\User;
use frontend\helpers\FileHelper;
use frontend\models\Files;
use frontend\modules\user\models\forms\EditProfileForm;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;
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

                    \unlink(Yii::getAlias('@frontend/web'.$file['file']));

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

        return $this->render('edit', [
            'user' => $user,
            'model' => $editProfileForm
        ]);
    }

}