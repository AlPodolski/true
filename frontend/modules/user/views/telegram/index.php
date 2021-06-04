<?php

/* @var $this \yii\web\View */
/* @var $user \common\models\User */
/* @var $tokenForm \frontend\modules\user\models\forms\CheckTelegramForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Привязать телеграм'

?>

<div class="container margin-top-20">
    <div class="row">

        <?php echo \frontend\modules\user\widgets\SidebarWidget::widget(['user' => $user]) ?>
        <div class="col-12 col-md-12 col-lg-6 col-xl-7">
            <ul class="margin-top-20">
                <li>Для того что бы привязать телеграм откройте нашего
                    <?php echo \yii\helpers\Html::a('бота',
                        Yii::$app->params['telegram_url'].Yii::$app->telegram->botUsername,
                        ['target' => 'blank']
                    )?></li>
                <li>Нажмите старт и Вам придет код</li>
                <li>Введите код в форму ниже (Включая тире)</li>
            </ul>

            <div class="pay-form-wrap">

                <?php $form = ActiveForm::begin(); ?>

                <div class="row">

                    <div class="col-6">

                        <?= $form->field($tokenForm, 'token')->textInput(['placeholder' => '999-999-999-999'])
                            ->label('Введите код полученный от телеграм бота:') ?>

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
