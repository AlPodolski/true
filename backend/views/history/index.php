<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\History */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php \yii\widgets\Pjax::begin([
        'id' => 'my_pjax',
        'options' => [
            'data-pjax-push-state' => 'my_pjax',
            'data-pjax-container' => 'my_pjax',
        ]
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'sum',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($item) {

                    /* @var $item common\models\History */

                    switch ($item->type) {
                        case \common\models\History::BALANCE_REPLENISHMENT:
                            return "Пополнение баланса";
                        case \common\models\History::UP_ANKET:
                            return "Поднятие анкеты";
                        case \common\models\History::BUY_VIEW:
                            return "Покупка просмотров";
                    }

                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($item) {

                    /* @var $item common\models\History */

                    return date('Y-m-d H:i:s', $item->created_at);

                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>


</div>
