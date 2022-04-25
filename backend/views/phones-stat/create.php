<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PhonesAdvert */

$this->title = 'Create Phones Advert';
$this->params['breadcrumbs'][] = ['label' => 'Phones Adverts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phones-advert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
