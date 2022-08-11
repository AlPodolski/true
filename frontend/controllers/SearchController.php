<?php


namespace frontend\controllers;

use common\models\City;
use frontend\helpers\MetaBuilder;
use frontend\models\SearchNameForm;
use frontend\modules\user\models\Posts;
use Yii;
use frontend\controllers\BeforeController as Controller;
use yii\data\Pagination;

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
            ->with('avatar', 'metro','gallery')
            ->where(['like', 'name', $model->name])
            ->orWhere(['like', 'phone', $model->name])
            ->andWhere(['city_id' => $cityInfo['id']])
            ->limit(Yii::$app->params['post_limit']);

        $countQuery = clone $prPosts;

        $pages = new Pagination([
            'totalCount' => $countQuery->cache(3600 * 12)->count(),
            'forcePageParam' => false,
            'defaultPageSize' => Yii::$app->params['post_limit']
        ]);

        $prPosts = $prPosts->offset($pages->offset)->all();

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
            ->with('avatar', 'metro','gallery')
            ->where(['like', 'name', $model->name])
            ->orWhere(['like', 'phone', $model->name])
            ->andWhere(['city_id' => $cityInfo['id']])
            ->limit(Yii::$app->params['post_limit']);


        $prPosts = $prPosts->offset(Yii::$app->params['post_limit'] * $page)->all();

        if ($prPosts) return $this->renderFile(Yii::getAlias('@frontend/views/search/more.php'), [
            'prPosts' => $prPosts
        ]);

        return '';

    }

}