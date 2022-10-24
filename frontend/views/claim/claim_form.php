<?php

/* @var $claimModal \common\models\Claim */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'claim-form',
    'action' => '/claim/add',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<?= $form->field($claimModal, 'author_email')->textInput()->label('Ваша почта') ?>
<?= $form->field($claimModal, 'author_name')->textInput()->label('Ваше имя') ?>
<?= $form->field($claimModal, 'text')->textarea()->label('Ваше сообщение, если сообщение связано с анкетой укажите ссылку на анкету') ?>
<script defer src='https://www.google.com/recaptcha/api.js?onload=onloadCallbackClaimRequest'></script>
<div id="request_claim_form" class="g-recaptcha" data-sitekey="6Lc6v2UiAAAAABk1eJQmDiW8N3FK8mDDxTSTr7bU"></div>
<script type="text/javascript">
    var onloadCallbackClaimRequest = function() {
        grecaptcha.render('request_claim_form', {
            'sitekey' : '6Lc6v2UiAAAAABk1eJQmDiW8N3FK8mDDxTSTr7bU'
        });
    };
</script>
<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'orange-btn d-block m-auto']) ?>
</div>

<?php ActiveForm::end() ?>
