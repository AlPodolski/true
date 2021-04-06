<?php


namespace frontend\modules\user\controllers;

use common\models\City;
use common\models\User;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\TopAnketBlock;
use Yii;
use yii\web\Controller;

class UpController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionIndex($city, $id)
    {
        if ($post = Posts::find()->where(['id' => $id])->limit(1)->one()){

            $cityInfo = City::getCity($city);

            $user = User::findOne(Yii::$app->user->id);

            if ($user['cash'] >= Yii::$app->params['up_anket_cost']){

                $transaction = Yii::$app->db->beginTransaction();

                $upAnketModel = new TopAnketBlock();

                $upAnketModel->post_id = $post['id'];
                $upAnketModel->city_id = $cityInfo['id'];
                $upAnketModel->valid_to = \time() + 3600;

                $user->cash = $user->cash - Yii::$app->params['up_anket_cost'];

                if ($upAnketModel->save() and $user->save()){

                    $transaction->commit();

                    Yii::$app->session->setFlash('success', 'Анкета '.$post->name.' поднята');

                    return $this->redirect('/cabinet');

                }else{

                    $transaction->rollBack();

                    Yii::$app->session->setFlash('warning', 'Ошибка');

                    return $this->redirect('/cabinet');

                }

            }else{

                Yii::$app->session->setFlash('warning', 'Недостаточно средств');

                return $this->redirect('/cabinet');

            }

        }

        return $this->redirect('/cabinet');

    }
}