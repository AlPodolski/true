<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetaTemplate */

$this->title = 'Create Meta Template';
$this->params['breadcrumbs'][] = ['label' => 'Meta Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
