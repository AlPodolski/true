<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Posts */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Анкеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    switch ($user['status']) {
                        case \frontend\modules\user\models\Posts::POST_ON_MODARATION_STATUS:
                            return  "Ожидает проверки";
                        case \frontend\modules\user\models\Posts::POST_ON_PUPLICATION_STATUS:
                            return  "Публикуется";
                        case \frontend\modules\user\models\Posts::POST_DONT_PUBLICATION_STATUS:
                            return "Не публикуется";
                    }

                    return 'Ошибка';

                },
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    return Html::a($user['name'],
                        'http://moskva.'.Yii::$app->params['site_name'] .'/post/'.$user['id'] ,
                        ['target' => '_blank']
                    );
                },
            ],

            [
                'attribute' => 'Аватар',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    $file = $user->getUserAvatar();
                    return Html::img('http://moskva.'.Yii::$app->params['site_name'] .$file, ['width' => '50px']);
                },
            ],

            'phone',
            'price',
            ['class' => 'backend\components\ActionColumnExtends'],
        ],
    ]); ?>


</div>
