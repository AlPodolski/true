<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FilterParams */

$this->title = 'Create Filter Params';
$this->params['breadcrumbs'][] = ['label' => 'Filter Params', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filter-params-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
