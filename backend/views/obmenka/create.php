<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ObmenkaOrder */

$this->title = 'Create Obmenka Order';
$this->params['breadcrumbs'][] = ['label' => 'Obmenka Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obmenka-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
