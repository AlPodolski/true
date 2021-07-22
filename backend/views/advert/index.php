<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adverts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advert-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Advert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'user_id',
            'timestamp:datetime',
            'text:ntext',
            'title',
            'type',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    /* @var $data \frontend\modules\advert\models\Advert */
                    switch ($data->status) {

                        case \frontend\modules\advert\models\Advert::STATUS_CHECK:
                            return 'Проверенно';
                        case \frontend\modules\advert\models\Advert::STATUS_NOT_CHECK:
                            return Html::label('Подтвердить', '#', [
                                    'data-id' => $data->id,
                                    'onclick' => 'check_advert(this)',
                            ]) ;
                    }
                },
            ],
            [
                'attribute' => 'type',
                'format' => 'text',
                'value' => function ($data) {
                    /* @var $data \frontend\modules\advert\models\Advert */
                    switch ($data->type) {
                        case \frontend\modules\advert\models\Advert::PUBLIC_TYPE:
                            return 'Страница с форума';
                        case \frontend\modules\advert\models\Advert::PRIVATE_CABINET_TYPE:
                            return 'Объявление из кабинета';
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
