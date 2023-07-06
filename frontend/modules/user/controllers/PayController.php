<?php


namespace frontend\modules\user\controllers;
use backend\models\History as HistorySearch;
use common\models\ObmenkaOrder;
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

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $key = Yii::$app->params['recaptcha-key'];
            $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];

            $data = json_decode(file_get_contents($query));

            if ( $data->success == false) {

                Yii::$app->session->setFlash('warning' , 'Капча введена неверно');
                Yii::$app->response->redirect(['/cabinet/pay?sort=-created_at'], 301, false);
                return true;

            }

            $tempData = ObmenkaOrder::find()
                ->where(['>=', 'created_at', time() - 300])
                ->andWhere(['status' => ObmenkaOrder::WAIT, 'user_id' => $model->user_id])
                ->count();

            if ($tempData >= 5){

                Yii::$app->session->setFlash('warning' , 'Достигнут лимит оплат, попробуйте позже');
                Yii::$app->response->redirect(['/cabinet/pay?sort=-created_at'], 301, false);

            }

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

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $key = Yii::$app->params['recaptcha-key'];
            $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];

            $data = json_decode(file_get_contents($query));

            if ( $data->success == false) {

                Yii::$app->session->setFlash('warning' , 'Капча введена неверно');
                Yii::$app->response->redirect(['/'], 301, false);
                return true;

            }

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