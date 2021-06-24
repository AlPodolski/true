<?php


namespace frontend\controllers;

use frontend\models\forms\GetCallForm;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;


class CallController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAdd()
    {
        $requestCall = new GetCallForm();

        if ($requestCall->load(Yii::$app->request->post()) and $requestCall->validate()) {

            $post = Posts::find()->where(['id' => $requestCall->post_id])->one();

            $requestCall->user_id = $post['user_id'];

            if ($requestCall->save()) {

                Yii::$app->session->setFlash('success', 'Ваша заявка отправлена');

                return $this->redirect('/post/' . $post['id']);

            }

        }

        Yii::$app->session->setFlash('warning', 'Ошибка попробуйте позже');

        return $this->redirect('/post/' . $post['id']);

    }
}