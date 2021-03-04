<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'about') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'check_photo_status') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'video') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'rost') ?>

    <?php // echo $form->field($model, 'breast') ?>

    <?php // echo $form->field($model, 'ves') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
