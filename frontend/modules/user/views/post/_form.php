<?php

/* @var $post \frontend\modules\user\models\Posts */
/* @var $city array */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$videoForm = new \frontend\modules\user\models\forms\VideoForm();
$avatarForm = new \frontend\modules\user\models\forms\AvatarForm();
$photoForm = new \frontend\modules\user\models\forms\PhotoForm();
$userNational = new \frontend\modules\user\models\UserNational();
$userMetro = new \frontend\models\UserMetro();
$userPlace = new \frontend\modules\user\models\UserPlace();
$userHairColor = new \frontend\modules\user\models\UserHairColor();
$userIntimHair = new \frontend\modules\user\models\UserIntimHair();
$userRayon = new \frontend\modules\user\models\UserRayon();
$userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();
$userService = new \frontend\modules\user\models\UserService();

$this->registerJsFile('/js/jquery.maskedinput.js', ['depends' => [yii\web\YiiAsset::className()]]);

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
]) ?>

    <div class="container">
        <div class="row">

            <div class="col-4">
                <div class="row">
                    <div class="col-12 main-photo">

                        <label for="addpost-image" class="<?php if (isset($model->img)) echo 'exist-img' ?> img-label no-img-bg main-img">

                            <?php if (isset($model->img)) : ?>

                                <img class="main-img" src="<?php echo Yii::$app->params['desc_path'].$model->img ?>">

                            <?php endif; ?>

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
                                <div class="gallery-wrap d-flex items-center " id="preview">
                                    <div class="no-img-bg small-no-img no-video">
                                        <label id="preview-video-label" for="addpost-video" class="img-label small-no-img-label">

                                        </label>
                                    </div>
                                </div>
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

            <div class="col-8">

                <div class="row">
                    <div class="col-6">
                        <?= $form->field($post, 'name')->textInput() ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($post, 'phone')->textInput() ?>
                    </div>
                    <div class="col-12">
                        <?= $form->field($post, 'about')->textarea() ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($post, 'price')->textInput(['value' => 3000]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($post, 'age')->textInput(['value' => 18]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($post, 'rost')->textInput(['value' => 160]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($post, 'breast')->textInput(['value' => 3]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($post, 'ves')->textInput(['value' => 50]) ?>
                    </div>

                    <div class="col-6">
                        <?= $form->field($userNational, 'national_id')
                            ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\National::getAll() , 'id' , 'value')) ?>
                    </div>

                    <div class="col-6">
                        <?= $form->field($userHairColor, 'hair_color_id')
                            ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\HairColor::getAll(), 'id' , 'value')) ?>
                    </div>

                    <div class="col-6">
                        <?= $form->field($userIntimHair, 'color_id')
                            ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\IntimHair::getAll(), 'id' , 'value')) ?>
                    </div>

                    <div class="col-6">

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
                    <div class="col-6">

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

                    <div class="col-6">

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

                    <div class="col-6">

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

                    <div class="col-6">

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