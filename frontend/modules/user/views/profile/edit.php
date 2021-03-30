<?php

/* @var $this \yii\web\View */
/* @var $model \frontend\modules\user\models\forms\EditProfileForm */
/* @var $user \common\models\User */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\widgets\PhotoWidget;

$this->title = 'Настройки пользователя';

?>

    <div class="container">

        <div class="row">
            <div class="col-12">
                <h1 class="margin-top-20"><?php echo $this->title ?></h1>
            </div>
            <div class="col-lg-5">

                <div class="white-cabinet-block cabinet-nav-block">

                    <div class="row">
                        <div class="col-6 d-flex items-center-left">
                            <div class="big-red-text">Профиль</div>
                        </div>
                        <div class="col-6 d-flex items-center-right">
                            <div class="user-name-short">
                                <?php if (isset($user['avatar']['file'])) : ?>

                                    <?php echo PhotoWidget::widget([
                                        'path' => $user['avatar']['file'] ,
                                        'size' => '100_100',
                                        'options' => [
                                            'class' => 'img user-img cabinet-img',
                                            'loading' => 'lazy',
                                        ],
                                    ]  ); ?>

                                <?php else: ?>

                                <?php echo mb_substr($model['username'], 0, 2) ; ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
                    ]) ?>

                    <?= $form->field($model, 'username') ?>

                    <?= $form->field($model, 'age') ?>

                    <?= $form->field($model, 'male')->radioList([1 => 'Мужской' , 2 => "Женский"] , [
                        'item' => function($index, $label, $name, $checked, $value) {
                            $chec = '';
                            $return = '<span>';
                            if ($index == 0) $chec = 'checked';
                            $return .= '<input '.$chec.' id="'.mb_strtolower($label).'_label-id" type="radio" name="' . $name . '" value="' . $value . '" tabindex="'.$index.'">';
                            $return .= '<label for="'.mb_strtolower($label).'_label-id" class="modal-radio '.mb_strtolower($label).'_label img-label-radio">';
                            $return .= $label;
                            $return .= '</label>';
                            $return .= '</span>';

                            return $return;
                        }
                    ]); ?>

                    <label for="editprofileform-avatar" class="editprofileform-avatar-label">

                    <span class="grey-text">
                        Аватар
                    </span>

                        <?= $form->field($model, 'avatar')
                            ->fileInput(['maxlength' => true, 'accept' => 'image/*'])->label(false) ?>

                        <span class="red-text">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 0C4.0371 0 0 4.0371 0 9C0 13.9629 4.0371 18 9 18C13.9629 18 18 13.9622 18 9C18 4.0378 13.9629 0 9 0ZM9 16.6057C4.80674 16.6057 1.39426 13.194 1.39426 9C1.39426 4.80604 4.80674 1.39426 9 1.39426C13.1933 1.39426 16.6057 4.80604 16.6057 9C16.6057 13.194 13.194 16.6057 9 16.6057Z" fill="#F74952"/>
                            <path d="M12.4859 8.24006H9.69735V5.45154C9.69735 5.06672 9.38573 4.75439 9.0002 4.75439C8.61468 4.75439 8.30305 5.06672 8.30305 5.45154V8.24006H5.51453C5.12901 8.24006 4.81738 8.55239 4.81738 8.93721C4.81738 9.32203 5.12901 9.63436 5.51453 9.63436H8.30305V12.4229C8.30305 12.8077 8.61468 13.12 9.0002 13.12C9.38573 13.12 9.69735 12.8077 9.69735 12.4229V9.63436H12.4859C12.8714 9.63436 13.183 9.32203 13.183 8.93721C13.183 8.55239 12.8714 8.24006 12.4859 8.24006Z" fill="#F74952"/>
                        </svg>
                            <span class="add-text">
                                <?php
                                if (isset($user['avatar']['file'])) echo 'Изменить';
                                else echo 'Добавить';
                                ?>
                            </span>
                    </span>

                    </label>

                    <div class="form-group margin-top-20">
                        <?= Html::submitButton('Сохранить', ['class' => 'orange-btn d-block m-auto']) ?>
                    </div>
                    <?php ActiveForm::end() ?>

                </div>

            </div>
            <div class="col-2"></div>
            <div class="col-lg-5"></div>
        </div>
    </div>