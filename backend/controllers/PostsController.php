<?php

namespace backend\controllers;

use common\components\helpers\AddEventHelper;
use common\models\History;
use common\models\PostMessage;
use common\models\Spisaniya;
use common\models\User;
use frontend\modules\advert\models\Advert;
use Yii;
use frontend\modules\user\models\Posts;
use backend\models\Posts as PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            \backend\components\behaviors\isAdminAuth::class,
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 100];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $oldStatus = $model->status;

        $postMessageModel = new PostMessage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($postMessageModel->load(Yii::$app->request->post()) and $postMessageModel->message) $postMessageModel->save();

            if ($oldStatus != $model->status){

                AddEventHelper::addStatus($oldStatus, $model);

            }

            return $this->redirect(['update', 'id' => $model->id]);

        }

        return $this->render('update', [
            'model' => $model,
            'postMessageModel' => $postMessageModel,
        ]);
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
         $this->findModel($id)->delete();

        if (Yii::$app->request->isGet) return $this->redirect(['index']);
    }

    public function actionCheck()
    {

        if ($model = $this->findModel(Yii::$app->request->post('id'))){

            if (Yii::$app->pay->pay($model['tarif']['sum'], $model['user_id'], History::POST_PUBLICATION, $model['id'])) {

                $model->pay_time = \time() + 3600;

                $model->status = Posts::POST_ON_PUPLICATION_STATUS;

                $sum = $model['tarif']['sum'];

                Spisaniya::add($sum);

            }

            else $model->status = Posts::POST_DONT_PUBLICATION_STATUS;

            if (Yii::$app->request->post('check')) $model->check_photo_status = Posts::ANKET_CHECK;

            $model->save();

            return 'Публикуется';

        }

    }

    /**
     *о Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::find()->where(['id' => $id])->with('allPhoto', 'checkPhoto', 'tarif')->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
