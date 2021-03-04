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
            'name',
            [
                'attribute' => 'Аватар',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    $file = $user->getUserAvatar();
                    return Html::img('http://msk.'.Yii::$app->params['site_name'] .$file, ['width' => '50px']);
                },
            ],

            'phone',
            'price',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
