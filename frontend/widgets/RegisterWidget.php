<?php


namespace frontend\widgets;

use yii\base\Widget;
use frontend\models\SignupForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

class RegisterWidget extends Widget
{
    public function run()
    {

        $model = new SignupForm();

        $form = ActiveForm::begin(['id' => 'form-signup',
            'action' => 'signup',
            'options' => [
            'class' => 'login-form'
        ]]); ?>

        <div class="login-text">Регистрация + Бонус</div>

        <?= $form->field($model, 'username')->textInput(['autofocus' => false, 'class' => 'form-input user-input' , 'placeholder' => 'Имя'])->label(false) ?>

        <?= $form->field($model, 'email')
        ->textInput(['autofocus' => false, 'placeholder' => 'Email', 'class' => 'form-input email-input'])
        ->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-input pass-input' , 'placeholder' => 'Пароль'])->label(false) ?>

        <script defer src='https://www.google.com/recaptcha/api.js'></script>
        <div class="g-recaptcha" data-sitekey="6Lcat2QiAAAAAKtCj3QUBAcxs5iJhDA28q1CMgol"></div>

        <div class="login-register-btns">
            <?= Html::submitButton('Регистрация', ['class' => 'in-btn', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end();

    }
}