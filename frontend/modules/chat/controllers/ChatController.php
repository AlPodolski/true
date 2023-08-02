<?php

namespace frontend\modules\chat\controllers;

use common\models\User;
use frontend\components\helpers\SaveFileHelper;
use frontend\models\Files;
use frontend\modules\chat\models\Chat;
use frontend\modules\chat\models\forms\SendMessageForm;
use frontend\modules\chat\models\forms\SendPhotoForm;
use frontend\modules\chat\models\Message;
use frontend\modules\chat\models\relation\UserDialog;
use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\user\controllers\CabinetBeforeController as Controller;
use yii\web\UploadedFile;

class ChatController extends Controller
{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);

    }

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }


    public function actionIndex($city)
    {

        return $this->render('list', [
            'user_id' => Yii::$app->user->id,
        ]);
    }

    public function actionGet($city)
    {

        if (Yii::$app->request->isPost) {

            $dialog_id = Yii::$app->request->post('dialog_id');

            $userToId = Yii::$app->request->post('to');

            $user = User::find()->where(['id' => Yii::$app->user->id])
                ->with('avatar')
                ->asArray()->one();

            $userTo = User::find()
                ->where(['id' => $userToId])
                ->with('avatar')
                ->asArray()
                ->one();


            return $this->renderFile(Yii::getAlias('@frontend/modules/chat/views/chat/get-dialog.php'), [
                'dialog_id' => $dialog_id,
                'user' => $user,
                'userTo' => $userTo,
                'recepient' => Yii::$app->request->post('id'),
            ]);

        }

        return false;

    }

    public function actionSend($city)
    {
        if (Yii::$app->request->isPost) {

            $model = new SendMessageForm();

            $model->from_id = Yii::$app->user->id;
            $model->created_at = \time();
            $model->to = Yii::$app->request->post('to');
            $model->text = Yii::$app->request->post('text');
            $model->chat_id = Yii::$app->request->post('dialog_id');

            $model->load(Yii::$app->request->post());

            if ($model->validate()) {

                $model->save();

            }

        }

    }

    public function actionPhoto()
    {
        $model = new SendPhotoForm();

        if ($model->load(Yii::$app->request->post())) {

            if (Message::find()->where(['from' => Yii::$app->user->id, 'status' => Message::MESSAGE_NOT_READ, 'class' => Files::class])->count())
                return 'Можно отправлять только 1 фото за раз';

            if ($file = UploadedFile::getInstance($model, 'file')) {

                $photo = SaveFileHelper::save($file, '', Message::class, '');

                $model->photo_id = $photo->id;

                if ($model->save()) echo $this->renderFile(Yii::getAlias('@frontend/modules/chat/views/chat/image.php'), [
                    'img' => $photo->file,
                ]);

                exit();


            }

        }

    }

    public function actionDelete()
    {
        if (Yii::$app->request->isPost){

            $id = Yii::$app->request->post('id');

            if ($userDialog = UserDialog::find()->where(['dialog_id' => $id, 'user_id' => Yii::$app->user->id])
                ->asArray()->all()){

                if ($message = Message::find()->where(['chat_id' => $id, 'class' => Files::class])->asArray()->all()){

                    foreach ($message as $messageItem){

                        $file = Files::find()->where(['id' => $messageItem['related_id']])->asArray()->one();

                        \unlink(Yii::getAlias('@frontend').'/web'.$file['file']);

                    }

                }

                Chat::deleteAll(['id' =>  $id]);
                \frontend\modules\chat\models\Message::deleteAll(['chat_id' => $id]);
                UserDialog::deleteAll(['dialog_id' => $id]);

            }

        }

        return true;

    }

}
