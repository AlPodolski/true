<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Redirect */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redirect-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_agent')
        ->dropDownList([
            \common\models\Redirect::ALL_REDIRECT => 'Редирект для всех',
            \common\models\Redirect::BOT_REDIRECT => 'Редирект для ботов',
            \common\models\Redirect::HUMAN_REDIRECT => 'Редирект для людей',
        ]) ?>

    <?= $form->field($model, 'status')
        ->dropDownList([
                \common\models\Redirect::STATUS_301 => 301,
                \common\models\Redirect::STATUS_302 => 302,
        ]) ?>

    <div class="form-group">
        <label for="check">Изменить актуальный город</label>
        <?= $form->field($model, 'check')
            ->checkbox()
            ->label('Изменить актуальный город') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
