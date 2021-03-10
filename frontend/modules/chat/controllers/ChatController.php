<?php

namespace frontend\modules\chat\controllers;

use common\models\User;
use frontend\models\Files;
use frontend\modules\chat\models\Chat;
use frontend\modules\chat\models\forms\SendMessageForm;
use frontend\modules\chat\models\forms\SendPhotoForm;
use frontend\modules\chat\models\Message;
use frontend\modules\chat\models\relation\UserDialog;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
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

    public function actionChat($city, $id)
    {

        $usersInDialog = ArrayHelper::getColumn(UserDialog::find()->where(['dialog_id' => $id])
            ->select('user_id')
            ->asArray()->all(), 'user_id');

        if (!\in_array(Yii::$app->user->id, $usersInDialog)) return $this->goHome();

        $user = Profile::find()->where(['id' => Yii::$app->user->id])->with('userAvatarRelations')->asArray()->one();

        $recepient_id = UserDialog::find()->where(['dialog_id' => $id])
            ->andWhere(['<>', 'user_id', Yii::$app->user->id])
            ->select('user_id')
            ->asArray()->one();

        $userTo = Profile::find()
            ->where(['id' => $recepient_id['user_id']])
            ->with('userAvatarRelations')
            ->with('privacyParams')
            ->asArray()
            ->one();

        return $this->render('dialog', [
            'dialog_id' => $id,
            'user' => $user,
            'userTo' => $userTo,
            'limitExist' => $limitExist,
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


            return $this->renderFile(Yii::getAlias('@app/modules/chat/views/chat/get-dialog.php'), [
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

                $dialog_id = $model->save();

            }



        }

    }

    public function actionSendPhoto()
    {
        $model = new SendPhotoForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($file = UploadedFile::getInstance($model, 'photo')) {

                $photo = SaveFileHelper::save($file, '', Message::class, '');

                $model->photo_id = $photo->id;

                $photoModel = $model->save();

                $photo->related_id = $photoModel->id;

                $photo->save();

                if ($model->to){

                    $params = array(
                        'file' => $photo->file,
                        'action' => 'sendPhoto',
                        'from' => $model->user_id,
                        'to' => $model->to,
                    );

                    SocketHelper::send_notification($params);

                }

                echo \json_encode(array('img' => $photo->file));

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
