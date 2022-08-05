<?php

/* @var $data array */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use common\models\CallReviewCategory;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin([
    'id' => 'claim-form',
    'action' => '/call/add-review',
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <h5 class="modal-title margin-top-20" >Пожалуйста оцените ответ</h5>
<?= $form->field($data['model'], 'post_id')->hiddenInput(['value' => $data['id']])->label(false) ?>
<?= $form->field($data['model'], 'reviewCategoryId')
    ->dropDownList(ArrayHelper::map(CallReviewCategory::find()->asArray()->all(), 'id', 'value'))
    ->label('Оценка ответа') ?>
<?= $form->field($data['model'], 'text')->textarea()->label('Комментарий') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'orange-btn d-block m-auto']) ?>
    </div>

<?php ActiveForm::end() ?>