<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FilterParams */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filter-params-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'relation_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column_param_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
