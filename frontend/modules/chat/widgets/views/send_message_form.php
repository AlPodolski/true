<?php

use yii\widgets\ActiveForm;

    $form = ActiveForm::begin([
        'action' => '#',
        'id' => 'message-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'options' => ['class' => 'form-horizontal'],
    ]) ?>

    <?= $form->field($model, 'text' )->textarea(['placeholder' => 'Напишите что то'])->label(false) ?>
    <?= $form->field($model, 'user_id',['options' => ['class' => 'd-none user-id-class']])->hiddenInput(['value' => ''])->label(false) ?>


    <span data-user-id="" onclick="send_message_form(this)" class="btn btn-primary message-form-send-btn flat_button">Отправить</span>

<?php ActiveForm::end() ?>