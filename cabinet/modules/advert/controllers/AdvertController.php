<?php


namespace cabinet\modules\advert\controllers;

use common\models\AdvertCategory;
use common\models\City;
use cabinet\components\helpers\CaptchaHelper;
use cabinet\helpers\MetaBuilder;
use cabinet\controllers\BeforeController as Controller;
use cabinet\modules\advert\components\helpers\AdvertHelper;
use cabinet\modules\advert\models\Advert;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class AdvertController extends Controller
{

    public function actionAd($city)
    {
        if (!CaptchaHelper::check()){
            Yii::$app->session->setFlash('warning' , 'Капча введена неверно');
            return Yii::$app->response->redirect(['/'], 301, false);
        }

        if (Yii::$app->user->isGuest) return $this->goHome();

        if (AdvertHelper::add( Yii::$app->request->post(), Yii::$app->user->identity )){
            return $this->redirect('/cabinet/advert');
        }

        return $this->redirect('/cabinet/pay');

    }

    public function actionList($city){

        $advertList = Advert::find()
            ->limit(Yii::$app->params['advert_limit'])
            ->orderBy('id DESC')
            ->where(['type' => Advert::PUBLIC_TYPE, 'status' => Advert::STATUS_CHECK])
            ->with('userRelations')
            ->cache(3600 * 24)
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

        $this->layout = '@cabinet/views/layouts/main-old.php';

        if (Yii::$app->user->isGuest) return $this->goHome();

        $advertList = Advert::find()
            ->limit(Yii::$app->params['advert_limit'])
            ->orderBy('id DESC')
            ->where(['type' => Advert::PRIVATE_CABINET_TYPE, 'status' => Advert::STATUS_CHECK])
            ->cache(3600 * 24)
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

        if ($city != 'moskva') throw new NotFoundHttpException();

        $advert = Advert::find()->where(['id' => $id])
            ->with('userRelations')
            ->with('comments')
            ->cache(3600 * 24)
            ->asArray()->one();

        return $this->render('view', [
            'advert' => $advert
        ]);
    }
    public function actionCabinetAdvertView($city, $id)
    {

        $this->layout = '@cabinet/views/layouts/main-old.php';

        if (Yii::$app->user->isGuest) return $this->goHome();

        $advert = Advert::find()->where(['id' => $id])
            ->with('userRelations')
            ->cache(3600 * 24)
            ->with('comments', 'category')
            ->asArray()->one();

        return $this->render('view', [
            'advert' => $advert,
            'isCabinet' => true,
        ]);
    }

    public function actionPublicAdvert($city)
    {

        if ($city != 'moskva') throw new NotFoundHttpException();

        $advertList = Advert::find()
            ->cache(3600 * 24)
            ->limit(Yii::$app->params['advert_limit'])
            ->orderBy('id DESC')
            ->where(['type' => Advert::PUBLIC_TYPE, 'status' => Advert::STATUS_CHECK])
            ->with('userRelations');

        if (Yii::$app->request->isPost){

            $advertList = Advert::find()
                ->limit(Yii::$app->params['advert_limit'])
                ->offset(Yii::$app->params['advert_limit'] * Yii::$app->request->post('page'))
                ->orderBy('id DESC')->all();

            $page = Yii::$app->request->post('page') + 1;

            if ($advertList) echo '<div data-url="'.Yii::$app->request->url.'/?page=' . $page . '" class="col-12"></div>';

            if ($advertList) echo $this->renderFile('@app/modules/advert/views/advert/more.php', [
                'advertList' => $advertList
            ]);

            exit();

        }

        $countQuery = clone $advertList;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'forcePageParam' => false,
            'defaultPageSize' => Yii::$app->params['post_limit']
        ]);

        $advertList = $advertList->offset($pages->offset);

        $advertList = $advertList->all();

        return $this->render('advert', [
            'advertList' => $advertList,
            'pages' => $pages,
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