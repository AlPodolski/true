<?php


namespace frontend\controllers;

use common\models\City;
use frontend\helpers\MetaBuilder;
use frontend\models\SearchNameForm;
use frontend\modules\user\models\Posts;
use Yii;
use frontend\controllers\BeforeController as Controller;

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
            ->all();

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
}