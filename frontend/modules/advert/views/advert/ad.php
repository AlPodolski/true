<?php

use frontend\widgets\UserSideBarWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile('/files/js/prev.js', ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerJsFile('/files/js/cabinet.js', ['depends' => [\frontend\assets\AppAsset::className()]]);

$this->title = 'Добавить объявление';

?>

<div class="row">

    <div class="col-12 col-xl-9">

            <div class="anket">

            <?php $form = ActiveForm::begin(); ?>

            <div class="col-12">

                <p class="name heading-anket">Добавить объявление</p>

                <?= $form->field($model, 'text')->textarea(['id' => 'advert-text-add'])->label(false) ?>

            </div>

            <div class="col-12">

                <div class="form-group add-button orange-btn">
                    <?= Html::submitButton('Сохранить', ['class' => 'in-cabinet']) ?>
                </div>

            </div>

            <?php ActiveForm::end() ?>

        </div>

    </div>

</div>

