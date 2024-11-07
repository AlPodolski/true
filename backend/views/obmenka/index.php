<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ObmenkaOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Obmenka Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obmenka-order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Obmenka Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($item) {

                    /* @var $item \common\models\ObmenkaOrder */

                    return '<div onclick="copyDataText(this)" data-text="'.$item->id.'-true"> '. $item->id .'</div>';

                },
            ],
            'user_id',
            'sum',
            'tracking_id',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($item) {

                    /* @var $item \common\models\ObmenkaOrder */

                    return $item->created_at ? date('Y-m-d H:i', $item->created_at) : '-';

                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($item) {

                    /* @var $item \common\models\ObmenkaOrder */

                    switch ($item->status) {
                        case \common\models\ObmenkaOrder::FINISH:
                            return 'Оплачен';
                        case \common\models\ObmenkaOrder::WAIT:
                            return 'Ожидает оплаты';
                    }

                },
            ],
            [
                'attribute' => 'payment_system',
                'format' => 'raw',
                'value' => function ($item) {

                    /* @var $item \common\models\ObmenkaOrder */

                    switch ($item->payment_system) {
                        case \common\models\ObmenkaOrder::OBMENKA_PAY_SYSTEM:
                            return 'Обменка';
                        case \common\models\ObmenkaOrder::BETA_PAY_SYSTEM:
                            return 'Бета';
                    }

                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
