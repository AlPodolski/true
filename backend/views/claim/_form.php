<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Claim */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claim-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'author_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([0 => 'Не прочитано', 1 => 'В обработке' , 2 => 'Обработано']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
