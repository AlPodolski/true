<?php


namespace frontend\modules\advert\controllers;

use common\models\AdvertCategory;
use frontend\helpers\MetaBuilder;
use frontend\controllers\BeforeController as Controller;
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

            Yii::$app->session->setFlash('success', 'Объявление добавлено');

            return $this->goBack();

        }

        return $this->render('ad', [
            'model' => $model,
        ]);

    }

    public function actionList($city){

        $advertList = Advert::find()
            ->limit(Yii::$app->params['advert_limit'])
            ->orderBy('id DESC')
            ->where(['type' => Advert::PUBLIC_TYPE, 'status' => Advert::STATUS_CHECK])
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
    public function actionCabinetAdvert($city){

        if (Yii::$app->user->isGuest) return $this->goHome();

        $advertList = Advert::find()
            ->limit(Yii::$app->params['advert_limit'])
            ->orderBy('id DESC')
            ->where(['type' => Advert::PRIVATE_CABINET_TYPE, 'status' => Advert::STATUS_CHECK])
            ->with('userRelations');

        $category = false;

        if ($category_id = Yii::$app->request->get('category')and $category = AdvertCategory::findOne($category_id)){

            $advertList = $advertList->andWhere(['category_id' => $category]);

        }

        if (Yii::$app->request->isPost){

            $advertList = Advert::find()
                ->limit(Yii::$app->params['advert_limit'])
                ->offset(Yii::$app->params['advert_limit'] * Yii::$app->request->post('page'))
                ->orderBy('id DESC')->all();

            if ($advertList) return $this->renderFile('@app/modules/advert/views/advert/more.php', [
                'advertList' => $advertList
            ]);

        }

        $advertList = $advertList->all();

        return $this->render('advert', [
            'advertList' => $advertList,
            'isCabinet' => true,
            'category' => $category,
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
    public function actionCabinetAdvertView($city, $id)
    {

        if (Yii::$app->user->isGuest) return $this->goHome();

        $advert = Advert::find()->where(['id' => $id])
            ->with('userRelations')
            ->with('comments', 'category')
            ->asArray()->one();

        return $this->render('view', [
            'advert' => $advert,
            'isCabinet' => true,
        ]);
    }

    public function actionPublicAdvert($city)
    {
        $advertList = Advert::find()
            ->limit(Yii::$app->params['advert_limit'])
            ->orderBy('id DESC')
            ->where(['type' => Advert::PUBLIC_TYPE, 'status' => Advert::STATUS_CHECK])
            ->with('userRelations');

        if (Yii::$app->request->isPost){

            $advertList = Advert::find()
                ->limit(Yii::$app->params['advert_limit'])
                ->offset(Yii::$app->params['advert_limit'] * Yii::$app->request->post('page'))
                ->orderBy('id DESC')->all();

            if ($advertList) return $this->renderFile('@app/modules/advert/views/advert/more.php', [
                'advertList' => $advertList
            ]);

        }

        $advertList = $advertList->all();

        return $this->render('advert', [
            'advertList' => $advertList,
            'isCabinet' => false,
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