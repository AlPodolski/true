<?php


namespace frontend\modules\user\controllers;
use backend\models\History as HistorySearch;
use frontend\components\helpers\CaptchaHelper;
use frontend\modules\user\models\forms\ObmenkaPayForm;
use frontend\modules\user\models\forms\PayForm;
use frontend\modules\user\models\Posts;
use Yii;
use frontend\modules\user\controllers\CabinetBeforeController as Controller;
use yii\web\NotFoundHttpException;

class PayController extends Controller
{

    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
        ];
    }

    public function actionObmenkaPay($city)
    {

        $model = new ObmenkaPayForm();

        if ($model->load(Yii::$app->request->post())){

            $model->user_id = Yii::$app->user->id;
            $model->city = $city;

            if ($model->validate()){

                if ($payUrl = $model->createPay() and isset($payUrl->pay_link)){

                    return $this->redirect($payUrl->pay_link);

                }

                Yii::$app->session->setFlash('warning', 'Ошибка');

            } else Yii::$app->session->setFlash('warning', 'Ошибка');

        }

        $searchModel = new HistorySearch();
        $params = Yii::$app->request->queryParams;
        $params['History']['user_id'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPay($city)
    {

        $model = new PayForm();

        $searchModel = new HistorySearch();
        $params = Yii::$app->request->queryParams;
        $params['History']['user_id'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if ($model->load(Yii::$app->request->post())){

            $model->user = Yii::$app->user->id;
            $model->city = $city;

            if ($model->validate()) return $this->redirect($model->pay()['payUrl']);

        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}