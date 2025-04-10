<?php
use common\models\LoginForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Авторизация';

?>

<div class="col-12">

    <?php

    $login = new LoginForm();

    $form = ActiveForm::begin(['id' => 'login-form',
        'action' => '/login',
        'options' => [
            'class' => 'login-form'
        ]]); ?>

    <h1>Войти в кабинет</h1>
    <link href="/css/style.css?v=1" rel="stylesheet">
    <?= $form->field($login, 'email')
        ->textInput(['autofocus' => false, 'placeholder' => 'Email', 'class' => 'form-input email-input'])
        ->label(false) ?>

    <?= $form->field($login, 'password')
        ->passwordInput(['placeholder' => 'Пароль', 'class' => 'form-input pass-input'])
        ->label(false) ?>


    <div class="checbox">
        <?= $form->field($login, 'rememberMe', [
            'template' => "{input} {label} {error}",
        ])->checkbox(['label' => false, 'class' => 'custom-checkbox'])->label('Запомнить меня ', [

        ]) ?>
    </div>

    <div id="register_recapcha" class="g-recaptcha"
         data-sitekey="6Lffq2EkAAAAAK4PuAXJjhnE1NOP1uUjANyEUxe_"></div>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallbackRegisterRequest" ></script>

    <div class="login-register-btns">
        <?= Html::submitButton('Войти', ['class' => 'in-btn', 'name' => 'login-button']) ?>
        <a href="/signup" class="register-btn">Регистрация</a>
    </div>

    <div class="social-in text-center">

        <br>

        <div class="in-with-text">
            Войти с помощью:
        </div>

        <?= AuthChoice::widget([
            'baseAuthUrl' => ['/auth'],
            'popupMode' => false,
        ]) ?>

    </div>


    <?php ActiveForm::end(); ?>

</div>