<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Claim */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="claim-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author_email:email',
            'author_name',
            'text',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return \date('Y-m-d H:i:s', $data->created_at);
                }

            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($data) {
                    return \date('Y-m-d H:i:s', $data->created_at);
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
        ],
    ]) ?>

</div>
