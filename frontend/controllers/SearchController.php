<?php


namespace frontend\controllers;

use common\models\City;
use common\models\Rayon;
use frontend\helpers\MetaBuilder;
use frontend\models\Metro;
use frontend\models\SearchNameForm;
use frontend\models\UserMetro;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserRayon;
use frontend\widgets\MetroWidget;
use Yii;
use frontend\controllers\BeforeController as Controller;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class SearchController extends Controller
{

    public $layout = '@app/views/layouts/main';

    public function actionName($city)
    {

        $model = new SearchNameForm();

        if (!$model->load( Yii::$app->request->get()) or !$model->name) return $this->goHome();

        $cityInfo = City::getCity($city);

        $prPosts = Posts::find()
            ->asArray()
            ->with('avatar', 'metro','gallery', 'tarif')
            ->where(['like', 'name', $model->name])
            ->orWhere(['like', 'phone', $model->name])
            ->andWhere(['city_id' => $cityInfo['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy('id DESC')
            ->limit(Yii::$app->params['post_limit']);

        $countQuery = clone $prPosts;

        $pages = new Pagination([
            'totalCount' => $count = $countQuery->cache(3600 * 12)->count(),
            'forcePageParam' => false,
            'defaultPageSize' => Yii::$app->params['post_limit']
        ]);

        if ($count) $prPosts = $prPosts->offset($pages->offset)->all();

        else{

            $prPosts = false;

            if (MetroWidget::checkExistMetro()){

                $metro = Metro::find()->where(['like', 'value', $model->name])
                    ->cache(3600 * 128)->one();

                if ($metro){

                    $ids = UserMetro::find()
                        ->where(['metro_id' => $metro->id, 'city_id' => $cityInfo['id']])
                        ->select('post_id')
                        ->asArray()
                        ->orderBy('id DESC')
                        ->cache(3600)
                        ->all();

                    $result = ArrayHelper::getColumn($ids, 'post_id');

                    $prPosts = Posts::find()
                        ->asArray()
                        ->with('avatar', 'metro','gallery')
                        ->where(['in', 'id', $result])
                        ->orderBy('id DESC')
                        ->limit(Yii::$app->params['post_limit']);

                    $countQuery = clone $prPosts;

                    $pages = new Pagination([
                        'totalCount' => $count = $countQuery->cache(3600 * 12)->count(),
                        'forcePageParam' => false,
                        'defaultPageSize' => Yii::$app->params['post_limit']
                    ]);

                    $prPosts = $prPosts->all();

                }

            }

            if (MetroWidget::checkExistRayon()){

                $rayon = Rayon::find()
                    ->where(['like', 'value', $model->name])
                    ->cache(3600 * 128)
                    ->one();

                if ($rayon){

                    $ids = UserRayon::find()
                        ->where(['rayon_id' => $rayon->id, 'city_id' => $cityInfo['id']])
                        ->select('post_id')
                        ->asArray()
                        ->cache(3600)
                        ->all();

                    $result = ArrayHelper::getColumn($ids, 'post_id');

                    $prPosts = Posts::find()
                        ->asArray()
                        ->with('avatar', 'metro','gallery')
                        ->where(['in', 'id', $result])
                        ->orderBy('id DESC')
                        ->limit(Yii::$app->params['post_limit']);

                    $prPosts = $prPosts->all();


                }

            }

        }

        $title = 'Проститутки '.$model->name.' – путаны и индивидуалки '.$cityInfo['city2'];
        $des = 'Путаны '.$model->name.' с удовольствием выполнят все Ваши желания. Выбор анкет индивидуалок. Номера телефонов';
        $h1 = 'Проститутки '.$model->name;

        return $this->render('index' , [
            'prPosts' => $prPosts,
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
        ]);
    }

    public function actionMore($city)
    {
        $page = Yii::$app->request->post('page') + 1;

        $model = new SearchNameForm();

        if (!$model->load( Yii::$app->request->get()) or !$model->name) return $this->goHome();

        $cityInfo = City::getCity($city);

        $prPosts = Posts::find()
            ->asArray()
            ->with('avatar', 'metro','gallery', 'tarif')
            ->where(['like', 'name', $model->name])
            ->orWhere(['like', 'phone', $model->name])
            ->andWhere(['city_id' => $cityInfo['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy('id DESC')
            ->limit(Yii::$app->params['post_limit']);

        $prPosts = $prPosts->offset(Yii::$app->params['post_limit'] * $page)->all();

        if ($prPosts) return $this->renderFile(Yii::getAlias('@frontend/views/search/more.php'), [
            'prPosts' => $prPosts
        ]);

        if (MetroWidget::checkExistMetro()){

            $metro = Metro::find()->where(['like', 'value', $model->name])
                ->cache(3600 * 128)->one();

            if ($metro){

                $ids = UserMetro::find()
                    ->where(['rayon_id' => $metro->id, 'city_id' => $cityInfo['id']])
                    ->select('post_id')
                    ->asArray()
                    ->cache(3600)
                    ->all();

                $result = ArrayHelper::getColumn($ids, 'post_id');

                $prPosts = Posts::find()
                    ->asArray()
                    ->with('avatar', 'metro','gallery')
                    ->where(['in', 'id', $result])
                    ->limit(Yii::$app->params['post_limit'])
                    ->orderBy('id DESC')
                    ->offset(Yii::$app->params['post_limit'] * $page);
                    $prPosts = $prPosts->all();

                    if ($prPosts) return $this->renderFile(Yii::getAlias('@frontend/views/search/more.php'), [
                        'prPosts' => $prPosts
                    ]);

            }

        }
        if (MetroWidget::checkExistRayon()){

            $rayon = Rayon::find()
                ->where(['like', 'value', $model->name])
                ->cache(3600 * 128)
                ->one();

            if ($rayon){

                $ids = UserRayon::find()
                    ->where(['rayon_id' => $rayon->id, 'city_id' => $cityInfo['id']])
                    ->select('post_id')
                    ->asArray()
                    ->cache(3600)
                    ->all();

                $result = ArrayHelper::getColumn($ids, 'post_id');

                $prPosts = Posts::find()
                    ->asArray()
                    ->with('avatar', 'metro','gallery')
                    ->where(['in', 'id', $result])
                    ->orderBy('id DESC')
                    ->limit(Yii::$app->params['post_limit'])
                    ->offset(Yii::$app->params['post_limit'] * $page);
                $prPosts = $prPosts->all();

                if ($prPosts) return $this->renderFile(Yii::getAlias('@frontend/views/search/more.php'), [
                    'prPosts' => $prPosts
                ]);

            }

        }

        return '';

    }

}