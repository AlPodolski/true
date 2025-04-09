<?php

use frontend\models\SignupForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';

$model = new SignupForm();

$form = ActiveForm::begin(['id' => 'form-signup',
    'action' => '/signup',
    'options' => [
        'class' => 'login-form'
    ]]); ?>

    <h1>Регистрация</h1>

<?= $form->field($model, 'username')->textInput(['autofocus' => false, 'class' => 'form-input user-input' , 'placeholder' => 'Имя'])->label(false) ?>

<?= $form->field($model, 'email')
    ->textInput(['autofocus' => false, 'placeholder' => 'Email', 'class' => 'form-input email-input'])
    ->label(false) ?>

<?= $form->field($model, 'password')->passwordInput(['class' => 'form-input pass-input' , 'placeholder' => 'Пароль'])->label(false) ?>

    <div id="register_recapcha" class="g-recaptcha" data-sitekey="6Lffq2EkAAAAAK4PuAXJjhnE1NOP1uUjANyEUxe_"></div>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallbackRegisterRequest" ></script>

    <div class="login-register-btns">
        <?= Html::submitButton('Регистрация', ['class' => 'in-btn', 'name' => 'signup-button']) ?>
        <a href="/login" class="register-btn">Войти</a>
    </div>

<?php ActiveForm::end();