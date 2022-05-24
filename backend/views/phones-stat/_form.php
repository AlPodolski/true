<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PhonesAdvert */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phones-advert-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['value' => $model->price ?? 2000]) ?>

    <?= $form->field($model, 'view')->textInput() ?>

    <?= $form->field($model, 'last_view')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([
            \common\models\PhonesAdvert::DONT_PUBLICATION_STATUS => 'Не публикуется',
            \common\models\PhonesAdvert::PUBLICATION_STATUS => 'Публикуется',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
