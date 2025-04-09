<?php

/* @var $data array */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'claim-form',
    'action' => '/claim/anket/add',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<h5 class="modal-title margin-top-20" >Опишите Вашу проблему</h5>
<?= $form->field($data['claim'], 'post_id')->hiddenInput(['value' => $data['id']])->label(false) ?>
<?= $form->field($data['claim'], 'reason')
    ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\ReasonClaim::find()->asArray()->all(), 'id', 'value'))
    ->label('Причина жалобы') ?>
<?= $form->field($data['claim'], 'email')->textInput()->label('Ваша почта') ?>
<?= $form->field($data['claim'], 'text')->textarea()->label('Комментарий') ?>

<script defer src='https://www.google.com/recaptcha/api.js?onload=onloadCallbackClaimPost'></script>
<div id="request_claim_post" class="g-recaptcha" data-sitekey="6Lffq2EkAAAAAK4PuAXJjhnE1NOP1uUjANyEUxe_"></div>
<script type="text/javascript">
    var onloadCallbackClaimPost = function() {
        grecaptcha.render('request_claim_post', {
            'sitekey' : '6Lffq2EkAAAAAK4PuAXJjhnE1NOP1uUjANyEUxe_'
        });
    };
</script>
<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'orange-btn d-block m-auto']) ?>
</div>

<?php ActiveForm::end() ?>
