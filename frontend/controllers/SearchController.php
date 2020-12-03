<?php


namespace frontend\controllers;

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

        if (!$model->load( Yii::$app->request->post()) or !$model->name) return $this->goHome();

        $prPosts = Posts::find()
            ->asArray()
            ->with('avatar', 'metro')
            ->where(['like', 'name', $model->name])
            ->all();

        return $this->render('index' , [
            'prPosts' => $prPosts,
            'name' => $model->name,
        ]);
    }
}