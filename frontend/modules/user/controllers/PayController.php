<?php


namespace frontend\modules\user\controllers;
use backend\models\History as HistorySearch;
use frontend\modules\user\models\forms\ObmenkaPayForm;
use frontend\modules\user\models\forms\PayForm;
use frontend\modules\user\models\Posts;
use Yii;
use yii\web\Controller;
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

            if($model->currency == 3){

                $order_id = Yii::$app->user->id.'_'.$city;

                $sign = \md5(Yii::$app->params['merchant_id'].':'.$model->sum.':'.Yii::$app->params['fk_merchant_key'].':'.$order_id);

                $email = Yii::$app->user->identity->email;

                $cassa_url = 'https://www.free-kassa.ru/merchant/cash.php?';

                $params = 'm='.Yii::$app->params['merchant_id'].
                    '&oa='.$model->sum.
                    '&o='.$order_id.
                    '&email='.$email.
                    '&s='.$sign;

                return Yii::$app->response->redirect($cassa_url.$params, 301, false);

            }

            $model->user_id = Yii::$app->user->id;
            $model->city = $city;

            if ($payUrl = $model->createPay() and isset($payUrl->pay_link)){

                return $this->redirect($payUrl->pay_link);

            }

            Yii::$app->session->setFlash('warning', 'Ошибка');

        }

        $searchModel = new HistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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