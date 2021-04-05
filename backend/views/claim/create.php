<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Claim */

$this->title = 'Create Claim';
$this->params['breadcrumbs'][] = ['label' => 'Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claim-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
