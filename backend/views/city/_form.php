<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\City */
/* @var $form yii\widgets\ActiveForm */

$domains = array();

foreach (Yii::$app->params['domains'] as $item){

    $domains[$item] = $item;

}

?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actual_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'external_domain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domain')
        ->dropDownList($domains) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
