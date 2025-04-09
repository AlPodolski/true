<?php


namespace cabinet\controllers;

use common\jobs\AddViewJob;
use common\models\City;
use common\models\Rayon;
use cabinet\components\helpers\GetOrderHelper;
use cabinet\helpers\MetaBuilder;
use cabinet\models\Metro;
use cabinet\models\SearchNameForm;
use cabinet\models\UserMetro;
use cabinet\modules\user\models\Posts;
use cabinet\modules\user\models\UserRayon;
use cabinet\widgets\MetroWidget;
use Yii;
use cabinet\controllers\BeforeController as Controller;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class SearchController extends Controller
{

   public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['name'],
                'duration' => 3600 * 4,
                'variations' => [
                    Yii::$app->request->url,
                    Yii::$app->request->get('name'),
                    Yii::$app->request->hostInfo,
                ],
            ],
        ];

    }

    public $layout = '@app/views/layouts/main';

    public function actionName($city)
    {

        $name = Yii::$app->request->get('name');

        if (!$name) return $this->goHome();

        $cityInfo = City::getCity($city);

        $prPosts = Posts::find()
            ->asArray()
            ->with('metro', 'avatar', 'place', 'strizhka', 'service', 'nacionalnost')
            ->where(['like', 'name', $name])
            ->andWhere(['city_id' => $cityInfo['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy((new GetOrderHelper())->get())
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

                $metro = Metro::find()->where(['like', 'value', $name])
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
                    ->where(['like', 'value', $name])
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

        $title = 'Проститутки '.$name.' – путаны и индивидуалки '.$cityInfo['city2'];
        $des = 'Путаны '.$name.' с удовольствием выполнят все Ваши желания. Выбор анкет индивидуалок. Номера телефонов';
        $h1 = 'Проститутки '.$name;

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

        $name = Yii::$app->request->get('name');

        if (!$name) return $this->goHome();

        $cityInfo = City::getCity($city);

        $prPosts = Posts::find()
            ->asArray()
            ->with('avatar', 'metro','gallery', 'tarif')
            ->where(['like', 'name', $name])
            ->orWhere(['like', 'phone', $name])
            ->andWhere(['city_id' => $cityInfo['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy((new GetOrderHelper())->get())
            ->limit(Yii::$app->params['post_limit']);

        $prPosts = $prPosts->offset(Yii::$app->params['post_limit'] * $page)->all();

        if ($prPosts) return $this->renderFile(Yii::getAlias('@cabinet/views/search/more.php'), [
            'prPosts' => $prPosts
        ]);

        if (MetroWidget::checkExistMetro()){

            $metro = Metro::find()->where(['like', 'value', $name])
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

                    if ($prPosts) return $this->renderFile(Yii::getAlias('@cabinet/views/search/more.php'), [
                        'prPosts' => $prPosts
                    ]);

            }

        }
        if (MetroWidget::checkExistRayon()){

            $rayon = Rayon::find()
                ->where(['like', 'value', $name])
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

                if ($prPosts) return $this->renderFile(Yii::getAlias('@cabinet/views/search/more.php'), [
                    'prPosts' => $prPosts
                ]);

            }

        }

        return '';

    }

}