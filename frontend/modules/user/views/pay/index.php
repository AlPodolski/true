<?php

/* @var $model \frontend\modules\user\models\forms\PayForm */
/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Пополнить баланс';

?>

<div class="container">

    <div class="row">

        <div class="col-12">
            <h1 class="margin-top-20">Пополнить баланс</h1>
        </div>

        <?php if ($model->hasErrors()) : ?>

            <div class="alert alert-success">
                <?php echo $model->getFirstError()?>
            </div>

        <?php endif; ?>

        <div class="col-4">
            <div class="balance-card">
                <div class="white-bold-text">Баланс</div>
                <div class=" big-white-text margin-top-20"><?php echo Yii::$app->user->identity['cash'] ?></div>
            </div>
        </div>

        <div class="col-8">

            <div class="pay-form-wrap">

                <?php $form = ActiveForm::begin(); ?>

                <div class="row">

                    <div class="col-6">

                        <?= $form->field($model, 'sum')->textInput(['value' => Yii::$app->params['min_pay']])
                            ->label('Введите сумму пополнения:') ?>

                    </div>

                    <div class="col-12">

                        <div class="form-group">
                            <?= Html::submitButton('Отправить', ['class' => 'orange-btn d-block']) ?>
                        </div>

                    </div>

                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>

    </div>

</div>


