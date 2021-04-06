<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Claim */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Claims';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claim-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Claim', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'author_email:email',
            'author_name',
            [
                'attribute' => 'text',
                'format' => 'text',
                'value' => function ($data) {
                    /* @var $data \common\models\Claim */
                    if (mb_strlen($data->text )> 50) return mb_substr($data->text, 0 , 50) . '...';
                    return $data->text;
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($data) {

                    return \date('Y-m-d H:i:s', $data->created_at);
                }

            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($data) {
                    /* @var $data \common\models\Claim */
                    return \date('Y-m-d H:i:s', $data->updated_at);

                }

            ],
            [
                'attribute' => 'status',
                'format' => 'text',
                'value' => function ($data) {
                    /* @var $data \common\models\Claim */

                    switch ($data->status) {
                        case 0:
                            return "Не прочитано";
                        case 1:
                            return "В обработке";
                        case 2:
                            return "Обработано";
                    }
                },
            ],

            ['class' => 'backend\components\ActionColumnExtends'],
        ],
    ]); ?>


</div>
