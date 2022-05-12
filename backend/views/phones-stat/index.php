<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\PhonesAdvert;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PhonesAdvertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Phones Adverts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phones-advert-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Phones Advert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'phone',
            'price',
            'view',
            [
                'attribute' => 'last_view',
                'format' => 'raw',
                'value' => function ($item) {
                    /* @var $item \common\models\PhonesAdvert */
                    return date('Y-m-d H:i:s', $item->last_view);
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($item) {
                    /* @var $item \common\models\PhonesAdvert */
                    return date('Y-m-d H:i:s', $item->created_at);
                },
            ],
            [
                'attribute' => 'city_id',
                'format' => 'raw',
                'value' => function ($item) {
                    /* @var $item \common\models\PhonesAdvert */
                    $item->getCity();
                    return $item->city->city;
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($item) {
                    /* @var $item \common\models\PhonesAdvert */
                    switch ($item->status) {
                        case \common\models\PhonesAdvert::PUBLICATION_STATUS:
                            return  "Публикуется";
                        case \common\models\PhonesAdvert::DONT_PUBLICATION_STATUS:
                            return  "Не публикуется";
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
