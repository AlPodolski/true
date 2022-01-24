<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FilterParams */

$this->title = 'Update Filter Params: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Filter Params', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="filter-params-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
