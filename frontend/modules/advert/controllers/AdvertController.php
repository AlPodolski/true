<?php


namespace frontend\modules\advert\controllers;

use frontend\helpers\MetaBuilder;
use yii\web\Controller;
use frontend\modules\advert\models\Advert;
use Yii;

class AdvertController extends Controller
{
    public function actionAd($city)
    {

        if (Yii::$app->user->isGuest) return $this->goHome();

        $model = new Advert();

        $model->timestamp = \time();

        $model->user_id = Yii::$app->user->id;

        if (Yii::$app->request->isPost and $model->load(Yii::$app->request->post()) and $model->save()){

            Yii::$app->session->setFlash('success', 'Объяление добавлено');

            return $this->redirect('/forum');

        }

        return $this->render('ad', [
            'model' => $model,
        ]);

    }

    public function actionList($city){

        $advertList = Advert::find()
            ->limit(Yii::$app->params['advert_limit'])
            ->orderBy('id DESC')
            ->with('userRelations')
            ->all();

        $uri = Yii::$app->request->url;

        $title =  MetaBuilder::Build($uri, $city, 'Title');
        $des = MetaBuilder::Build($uri, $city, 'des');
        $h1 = MetaBuilder::Build($uri, $city, 'h1');

        return $this->render('advert', [
            'advertList' => $advertList,
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
        ]);
    }

    public function actionView($city, $id)
    {
        $advert = Advert::find()->where(['id' => $id])
            ->with('userRelations')
            ->with('comments')
            ->asArray()->one();

        return $this->render('view', [
            'advert' => $advert
        ]);
    }

    public function actionMore()
    {
        if (Yii::$app->request->isPost){

            $advertList = Advert::find()
                ->limit(Yii::$app->params['advert_limit'])
                ->offset(Yii::$app->params['advert_limit'] * Yii::$app->request->post('page'))
                ->orderBy('id DESC')->all();

            if ($advertList) return $this->renderFile('@app/modules/advert/views/advert/more.php', [
                'advertList' => $advertList
            ]);

        }

        exit();
    }

}