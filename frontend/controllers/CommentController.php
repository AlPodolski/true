<?php


namespace frontend\controllers;

use common\models\Comments;
use frontend\helpers\CommentsHelper;
use frontend\models\forms\AddCommentForm;
use Yii;
use yii\web\Controller;

class CommentController extends Controller
{
    public function actionIndex()
    {

        if (Yii::$app->request->isPost){

            if (!Yii::$app->user->isGuest){

                $model = new AddCommentForm();

                $model->author_id = Yii::$app->user->id;
                $model->created_at = \time();

                if ($model->load(Yii::$app->request->post()) and $model->validate() and  $id = $model->save()){

                    $comment = Comments::find()->where(['id' => $id])->with('author')->asArray()->one();

                    if ($user_id = CommentsHelper::getCommentOwner($comment['related_id'], $comment['class'] ) and $user_id['user_id'] != $model->author_id){

                        return  $this->renderFile('@app/views/comment/comment-item.php', [
                            'comment' => $comment
                        ]);

                    }

                }

            }

        }

    }
}