<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_id')->textInput() ?>

    <?= $form->field($model, 'author')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'photo_marc')->textInput() ?>

    <?= $form->field($model, 'total_marc')->textInput() ?>

    <?= $form->field($model, 'clean')->textInput() ?>

    <?= $form->field($model, 'is_happy')->textInput() ?>

    <?= $form->field($model, 'is_moderate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
