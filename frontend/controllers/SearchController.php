<?php


namespace frontend\controllers;

use common\models\City;
use frontend\helpers\MetaBuilder;
use frontend\models\SearchNameForm;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;

class SearchController extends Controller
{

    public $layout = '@app/views/layouts/main';

    public function actionName($city)
    {

        $model = new SearchNameForm();

        if (!$model->load( Yii::$app->request->get()) or !$model->name) return $this->goHome();

        $prPosts = Posts::find()
            ->asArray()
            ->with('avatar', 'metro')
            ->where(['like', 'name', $model->name])
            ->all();

        $cityInfo = City::getCity($city);

        $title = 'Проститутки по имени '.$model->name.' – путаны и индивидуалки '.$cityInfo['city2'];
        $des = 'Путаны с именем '.$model->name.' с удовольствием выполнят все Ваши желания. Выбор анкет индивидуалок. Номера телефонов';
        $h1 = 'Проститутки с именем '.$model->name;

        return $this->render('index' , [
            'prPosts' => $prPosts,
            'title' => $title,
            'des' => $des,
            'h1' => $h1,
        ]);
    }
}