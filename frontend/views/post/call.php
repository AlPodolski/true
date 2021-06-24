<?php

/* @var $data array */
/* @var $this \yii\web\View */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

echo '<script src="/js/jquery.maskedinput.min.js"></script>';

$form = ActiveForm::begin([
    'id' => 'claim-form',
    'action' => '/call/add',
    'options' => ['class' => 'form-horizontal'],
]) ?>

    <h5 class="modal-title margin-top-20" id="exampleModalLabel">Заказать звонок</h5>
<?= $form->field($data['call'], 'post_id')->hiddenInput(['value' => $data['id']])->label(false) ?>
<?= $form->field($data['call'], 'phone')->textInput(['placeholder' => 'Введите свой номер'])
    ->label('Ваш номер') ?>

<?= $form->field($data['call'], 'text')->textInput(['placeholder' => 'Введите свой комментарий'])
    ->label('Ваш комментарий') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'orange-btn d-block m-auto']) ?>
    </div>

<?php ActiveForm::end() ?>