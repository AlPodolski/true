<?php

/* @var $post \frontend\modules\user\models\Posts */
/* @var $city array */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->registerJsFile('/js/jquery.maskedinput.js', ['depends' => [yii\web\YiiAsset::className()]]);
$this->registerJsFile('/js/form_cabinet.js', ['depends' => [yii\web\YiiAsset::className()]]);

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
]) ?>

    <div class="container">
        <div class="row">

            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-12 main-photo">

                        <?php $style = '' ?>

                        <?php if (isset($post['avatar']['file'])) : ?>

                            <?php $style = 'background-image: url('.$post['avatar']['file'].')'; ?>

                        <?php endif; ?>

                        <label for="addpost-image" style="<?php echo $style ?>" id="cabinet-main-img-label" class=" img-label no-img-bg main-img">

                            <?= $form->field($avatarForm, 'avatar')
                                ->fileInput(['maxlength' => true, 'accept' => 'image/*', 'id' => 'addpost-image'])
                                ->label(false) ?>

                            <div class="plus-photo-wrap d-flex items-center">

                                <span class="plus d-flex items-center">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.15 7.65H9.35005V0.849948C9.35005 0.38085 8.9692 0 8.49995 0C8.03085 0 7.65 0.38085 7.65 0.849948V7.65H0.849948C0.38085 7.65 0 8.03085 0 8.49995C0 8.9692 0.38085 9.35005 0.849948 9.35005H7.65V16.15C7.65 16.6192 8.03085 17.0001 8.49995 17.0001C8.9692 17.0001 9.35005 16.6192 9.35005 16.15V9.35005H16.15C16.6192 9.35005 17.0001 8.9692 17.0001 8.49995C17.0001 8.03085 16.6192 7.65 16.15 7.65Z" fill="white"/>
                                    </svg>
                                </span>

                            </div>

                        </label>

                    </div>

                    <div class="col-12">

                        <p class="black-text font-weight-bold">
                            Галерея
                        </p>
                        <div class="row">

                            <div class="col-12">

                                <?php if (isset($photoForm->photo) and $photoForm->photo) : ?>

                                <div class="gallery-wrap d-flex items-center ">

                                    <div class="small-no-img">
                                        <label for="addpost-photo" class="add-photoimg-label small-no-img-label d-flex items-center">
                                            <div class="plus-photo-wrap d-flex items-center">
                                                <span class="plus d-flex items-center">
                                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.15 7.65H9.35005V0.849948C9.35005 0.38085 8.9692 0 8.49995 0C8.03085 0 7.65 0.38085 7.65 0.849948V7.65H0.849948C0.38085 7.65 0 8.03085 0 8.49995C0 8.9692 0.38085 9.35005 0.849948 9.35005H7.65V16.15C7.65 16.6192 8.03085 17.0001 8.49995 17.0001C8.9692 17.0001 9.35005 16.6192 9.35005 16.15V9.35005H16.15C16.6192 9.35005 17.0001 8.9692 17.0001 8.49995C17.0001 8.03085 16.6192 7.65 16.15 7.65Z" fill="white"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </label>
                                    </div>


                                    <?php foreach ($photoForm->photo as $photoItem) : ?>

                                        <div class="small-no-img preview-with-photo">

                                            <label for="addpost-photo" class="img-label ">

                                                <img class="preview " src="<?php echo $photoItem['file'] ?>" alt="">

                                            </label>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                                    <div class="gallery-wrap d-flex items-center " id="preview">
                                    </div>

                                <?php else : ?>

                                    <div class="gallery-wrap d-flex items-center " id="preview">
                                    <div class="no-img-bg small-no-img">
                                        <label for="addpost-photo" class="img-label small-no-img-label">

                                        </label>
                                    </div>

                                    <div class="no-img-bg small-no-img">
                                        <label for="addpost-photo" class="img-label small-no-img-label">

                                        </label>
                                    </div>

                                    <div class="no-img-bg small-no-img">
                                        <label for="addpost-photo" class="img-label small-no-img-label">

                                        </label>
                                    </div>
                                </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <?= $form->field($photoForm, 'photo[]')
                            ->fileInput(['maxlength' => true,
                                'accept' => 'image/*',
                                'multiple' => true,
                                'id' => 'addpost-photo',
                                'class' => 'd-none'
                                ])
                            ->label(false) ?>

                    </div>
                    <div class="col-12">

                        <p class="black-text font-weight-bold">
                            Видео
                        </p>
                        <div class="row">

                            <div class="col-12">

                                <?php if ($post['video']) : ?>

                                    <div class="gallery-wrap d-flex items-center" id="preview">

                                        <label id="preview-video-label" for="addpost-video" class="img-label">
                                            <video controls="controls">
                                                <source src="<?php echo $post['video'] ?>" >
                                            </video>
                                        </label>

                                        <label id="change-video-label" for="addpost-video" class="img-label">
                                            Изменить видео
                                        </label>

                                    </div>

                                <?php else : ?>

                                    <div class="gallery-wrap d-flex items-center " id="preview">
                                        <div class="no-img-bg small-no-img no-video">
                                            <label id="preview-video-label" for="addpost-video" class="img-label small-no-img-label">

                                            </label>
                                        </div>
                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <?= $form->field($videoForm, 'video')
                            ->fileInput(['maxlength' => true,
                                'accept' => 'video/*',
                                'multiple' => false,
                                'id' => 'addpost-video',
                                'class' => 'd-none'
                                ])
                            ->label(false) ?>

                    </div>

                </div>

            </div>

            <div class="col-12 col-md-8">

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <?= $form->field($post, 'name')->textInput() ?>
                    </div>
                    <div class="col-12 col-sm-6">
                        <?= $form->field($post, 'phone')->textInput() ?>
                    </div>
                    <div class="col-12">
                        <?= $form->field($post, 'about')->textarea() ?>
                    </div>
                    <div class="col-12 col-sm-6">
                        <?= $form->field($post, 'price')->textInput() ?>
                    </div>
                    <div class="col-12 col-sm-6">
                        <?= $form->field($post, 'age')->textInput() ?>
                    </div>
                    <div class="col-12 col-sm-6">
                        <?= $form->field($post, 'rost')->textInput() ?>
                    </div>
                    <div class="col-12 col-sm-6">
                        <?= $form->field($post, 'breast')->textInput() ?>
                    </div>
                    <div class="col-12 col-sm-6">
                        <?= $form->field($post, 'ves')->textInput() ?>
                    </div>

                    <div class="col-12 col-sm-6">
                        <?= $form->field($userNational, 'national_id')
                            ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\National::getAll() , 'id' , 'value')) ?>
                    </div>

                    <div class="col-12 col-sm-6">
                        <?= $form->field($userHairColor, 'hair_color_id')
                            ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\HairColor::getAll(), 'id' , 'value')) ?>
                    </div>

                    <div class="col-12 col-sm-6">
                        <?= $form->field($userIntimHair, 'color_id')
                            ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\IntimHair::getAll(), 'id' , 'value')) ?>
                    </div>

                    <div class="col-12 col-sm-6">

                        <?= $form->field($userMetro, 'metro_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => ArrayHelper::map(\frontend\models\Metro::getMetro($city['id']), 'id' , 'value'),
                            'language' => 'de',
                            'options' => ['placeholder' => 'Выбрать метро ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]) ?>

                    </div>
                    <div class="col-12 col-sm-6">

                        <?= $form->field($userRayon, 'rayon_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => ArrayHelper::map(\common\models\Rayon::getAll($city['id']), 'id' , 'value'),
                            'language' => 'de',
                            'options' => ['placeholder' => 'Выбрать район ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]) ?>
                    </div>

                    <div class="col-12 col-sm-6">

                        <?= $form->field($userOsobenosti, 'param_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => ArrayHelper::map(\common\models\Osobenosti::getAll(), 'id' , 'value'),
                            'language' => 'de',
                            'options' => ['placeholder' => 'Выбрать особености ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]) ?>
                    </div>

                    <div class="col-12 col-sm-6">

                        <?= $form->field($userService, 'service_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => ArrayHelper::map(\common\models\Service::getService(), 'id' , 'value'),
                            'language' => 'de',
                            'options' => ['placeholder' => 'Выбрать особености ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]) ?>
                        </div>

                    <div class="col-12 col-sm-6">

                        <?= $form->field($userPlace, 'place_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => ArrayHelper::map(\common\models\Place::getPlace(), 'id' , 'value'),
                            'language' => 'de',
                            'options' => ['placeholder' => 'Выбрать особености ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]) ?>
                    </div>

                </div>

                <?= Html::submitButton('Сохранить', ['class' => 'orange-btn d-block m-auto']) ?>

            </div>

        </div>
    </div>

<?php ActiveForm::end() ?>