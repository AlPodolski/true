<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\Redirect */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Redirects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redirect-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Redirect', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'from',
            'to',
            [
                'attribute' => 'user_agent',
                'format' => 'raw',
                'value' => function ($item) {

                    /* @var $review \common\models\Redirect */

                    switch ($item->user_agent) {
                        case \common\models\Redirect::BOT_REDIRECT:
                            return 'Боты';
                        case \common\models\Redirect::HUMAN_REDIRECT:
                            return 'Люди';
                        case \common\models\Redirect::ALL_REDIRECT:
                            return 'Все';
                    }

                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($item) {

                    /* @var $review \common\models\Redirect */

                    switch ($item->status) {
                        case \common\models\Redirect::STATUS_301:
                            return '301';
                        case \common\models\Redirect::STATUS_302:
                            return '302';
                    }

                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
