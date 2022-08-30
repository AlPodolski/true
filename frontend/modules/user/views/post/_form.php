<?php

/* @var $post \frontend\modules\user\models\Posts */
/* @var $city array */

/* @var $checkPhotoForm \frontend\modules\user\models\forms\CheckPhotoForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->registerJsFile('/js/jquery.maskedinput.js', ['depends' => [yii\web\YiiAsset::className()]]);
$this->registerJsFile('/js/form_cabinet.js?v=2', ['depends' => [yii\web\YiiAsset::className()]]);
$this->registerJsFile('/js/yandex.js?v=3', ['depends' => [yii\web\YiiAsset::className()]]);

$tarifList = array();

foreach (\common\models\Tarif::getAll() as $item) {

    $tarifList[] = array('id' => $item['id'], 'value' => $item['value'] . ' - ' . $item['sum'] . ' руб. в час');

}

?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
]) ?>

<div class="container">
    <div class="row">

        <div class="col-12">

            <?php if (isset($post['name']) and $post['name']) : ?>

                <p>Осталось показов: <?php echo $post['view'] ?></p>

            <?php endif; ?>

        </div>

        <?php if ($post['message']) : ?>

            <div class="col-12">

                <?php foreach ($post['message'] as $item) : ?>

                    <div class="alert alert-warning"><?php echo $item['message'] ?>
                        <span class="text-left alert-small-text">Создано : <?php echo date('Y-m-d', $item['created_at']) ?></span>
                        <button type="button" class="close" onclick="set_read_message(this)"
                                data-id="<?php echo $item['id']; ?>" data-dismiss="alert">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <div class="col-12 col-md-4">
            <div class="row">

                <div class="col-12 main-photo">

                    <p class="black-text font-weight-bold">Основное фото (Используйте фото высокого качества)</p>

                    <?php $style = '' ?>

                    <?php if (isset($post['avatar']['file'])) : ?>

                        <?php $style = 'background-image: url(' . $post['avatar']['file'] . ')'; ?>

                    <?php endif; ?>

                    <label for="addpost-image" style="<?php echo $style ?>" id="cabinet-main-img-label"
                           class=" img-label no-img-bg main-img">

                        <?= $form->field($avatarForm, 'avatar')
                            ->fileInput(['maxlength' => true, 'accept' => '.jpg, .jpeg', 'id' => 'addpost-image'])
                            ->label(false) ?>

                        <div class="plus-photo-wrap d-flex items-center">

                                <span class="plus d-flex items-center">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.15 7.65H9.35005V0.849948C9.35005 0.38085 8.9692 0 8.49995 0C8.03085 0 7.65 0.38085 7.65 0.849948V7.65H0.849948C0.38085 7.65 0 8.03085 0 8.49995C0 8.9692 0.38085 9.35005 0.849948 9.35005H7.65V16.15C7.65 16.6192 8.03085 17.0001 8.49995 17.0001C8.9692 17.0001 9.35005 16.6192 9.35005 16.15V9.35005H16.15C16.6192 9.35005 17.0001 8.9692 17.0001 8.49995C17.0001 8.03085 16.6192 7.65 16.15 7.65Z"
                                              fill="white"/>
                                    </svg>
                                </span>

                        </div>

                    </label>

                </div>

                <div class="col-12">
                    <br>
                </div>

                <div class="col-12 main-photo">

                    <p class="black-text font-weight-bold">Проверочное фото</p>

                    <div class="accordion accordion-custom" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-block text-left collapsed" type="button"
                                            data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                                  fill="#F74952"/>
                                        </svg>
                                    </span>
                                        <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z"
      fill="#F74952"/>
</svg>

                                    </span>
                                        Подробнее о подтверждении личности...
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse " aria-labelledby="headingOne"
                                 data-parent="#accordionExample">
                                <div class="card-body">
                                    <p class="black-text">Фото будет доступно только Вам и администрации, больше никто
                                        не получит
                                        доступ к фото </p>
                                    <p class="black-text">На фото должно быть видно лицо, должно быть понятно что фото
                                        со страницы и проверочное фото принадлежат одному и тому же человеку, на фото
                                        должна быть табличка
                                        с названием сайта, датой добавления и номером телефона указаном а анкете</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php $style = '' ?>

                    <?php if (isset($post['checkPhoto']['file'])) : ?>

                        <?php $style = 'background-image: url(' . $post['checkPhoto']['file'] . ')'; ?>

                    <?php endif; ?>

                    <label for="addpost-check-image" style="<?php echo $style ?>" id="cabinet-main-img-label"
                           class="margin-top-20 img-label no-img-bg main-img check-photo-label">
                        <?= $form->field($checkPhotoForm, 'file')
                            ->fileInput(['maxlength' => true, 'accept' => '.jpg, .jpeg', 'id' => 'addpost-check-image'])
                            ->label(false) ?>

                        <div class="plus-photo-wrap d-flex items-center">

                                <span class="plus d-flex items-center">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.15 7.65H9.35005V0.849948C9.35005 0.38085 8.9692 0 8.49995 0C8.03085 0 7.65 0.38085 7.65 0.849948V7.65H0.849948C0.38085 7.65 0 8.03085 0 8.49995C0 8.9692 0.38085 9.35005 0.849948 9.35005H7.65V16.15C7.65 16.6192 8.03085 17.0001 8.49995 17.0001C8.9692 17.0001 9.35005 16.6192 9.35005 16.15V9.35005H16.15C16.6192 9.35005 17.0001 8.9692 17.0001 8.49995C17.0001 8.03085 16.6192 7.65 16.15 7.65Z"
                                              fill="white"/>
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
                                        <label for="addpost-photo"
                                               class="add-photoimg-label small-no-img-label d-flex items-center">
                                            <div class="plus-photo-wrap d-flex items-center">
                                                <span class="plus d-flex items-center">
                                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.15 7.65H9.35005V0.849948C9.35005 0.38085 8.9692 0 8.49995 0C8.03085 0 7.65 0.38085 7.65 0.849948V7.65H0.849948C0.38085 7.65 0 8.03085 0 8.49995C0 8.9692 0.38085 9.35005 0.849948 9.35005H7.65V16.15C7.65 16.6192 8.03085 17.0001 8.49995 17.0001C8.9692 17.0001 9.35005 16.6192 9.35005 16.15V9.35005H16.15C16.6192 9.35005 17.0001 8.9692 17.0001 8.49995C17.0001 8.03085 16.6192 7.65 16.15 7.65Z"
                                                              fill="white"></path>
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
                            'accept' => '.jpg, .jpeg',
                            'multiple' => true,
                            'id' => 'addpost-photo',
                            'class' => 'd-none'
                        ])
                        ->label(false) ?>

                </div>
                <div class="col-12">

                    <p class="black-text font-weight-bold">
                        Селфи(Фотография самого себя)
                    </p>
                    <div class="row">

                        <div class="col-12">

                            <?php if (isset($selphiForm->photo) and $selphiForm->photo) : ?>

                                <div class="gallery-wrap d-flex items-center ">

                                    <div class="small-no-img">
                                        <label for="addpost-selphi"
                                               class="add-photoimg-label small-no-img-label d-flex items-center">
                                            <div class="plus-photo-wrap d-flex items-center">
                                                <span class="plus d-flex items-center">
                                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.15 7.65H9.35005V0.849948C9.35005 0.38085 8.9692 0 8.49995 0C8.03085 0 7.65 0.38085 7.65 0.849948V7.65H0.849948C0.38085 7.65 0 8.03085 0 8.49995C0 8.9692 0.38085 9.35005 0.849948 9.35005H7.65V16.15C7.65 16.6192 8.03085 17.0001 8.49995 17.0001C8.9692 17.0001 9.35005 16.6192 9.35005 16.15V9.35005H16.15C16.6192 9.35005 17.0001 8.9692 17.0001 8.49995C17.0001 8.03085 16.6192 7.65 16.15 7.65Z"
                                                              fill="white"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </label>
                                    </div>


                                    <?php foreach ($selphiForm->photo as $photoItem) : ?>

                                        <div class="small-no-img preview-with-photo">

                                            <label for="addpost-selphi" class="img-label ">

                                                <img class="preview " src="<?php echo $photoItem['file'] ?>" alt="">

                                            </label>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                                <div class="gallery-wrap d-flex items-center " id="previewselphi">
                                </div>

                            <?php else : ?>

                                <div class="gallery-wrap d-flex items-center " id="previewselphi">
                                    <div class="no-img-bg small-no-img">
                                        <label for="addpost-selphi" class="img-label small-no-img-label">

                                        </label>
                                    </div>

                                    <div class="no-img-bg small-no-img">
                                        <label for="addpost-selphi" class="img-label small-no-img-label">

                                        </label>
                                    </div>

                                    <div class="no-img-bg small-no-img">
                                        <label for="addpost-selphi" class="img-label small-no-img-label">

                                        </label>
                                    </div>
                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                    <?= $form->field($selphiForm, 'photo[]')
                        ->fileInput(['maxlength' => true,
                            'accept' => '.jpg, .jpeg',
                            'multiple' => true,
                            'id' => 'addpost-selphi',
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
                                            <source src="<?php echo $post['video'] ?>">
                                        </video>
                                    </label>

                                    <label id="change-video-label" for="addpost-video" class="img-label">
                                        Изменить видео
                                    </label>

                                </div>

                            <?php else : ?>

                                <div class="gallery-wrap d-flex items-center " id="preview">
                                    <div class="no-img-bg small-no-img no-video">
                                        <label id="preview-video-label" for="addpost-video"
                                               class="img-label small-no-img-label">

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
                    <?= $form->field($post, 'express_price')->textInput() ?>
                </div>
                <div class="col-12 col-sm-6">
                    <?= $form->field($post, 'price')->textInput() ?>
                </div>
                <div class="col-12 col-sm-6">
                    <?= $form->field($post, 'price_2_hour')->textInput() ?>
                </div>
                <div class="col-12 col-sm-6">
                    <?= $form->field($post, 'price_night')->textInput() ?>
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
                        ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\National::getAll(), 'id', 'value')) ?>
                </div>

                <div class="col-12 col-sm-6">
                    <?= $form->field($userHairColor, 'hair_color_id')
                        ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\HairColor::getAll(), 'id', 'value')) ?>
                </div>

                <div class="col-12 col-sm-6">
                    <?= $form->field($userIntimHair, 'color_id')
                        ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\IntimHair::getAll(), 'id', 'value')) ?>
                </div>

                <div class="col-12 col-sm-6">

                    <?= $form->field($userMetro, 'metro_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => ArrayHelper::map(\frontend\models\Metro::getMetro($city['id']), 'id', 'value'),
                        'language' => 'ru',
                        'options' => ['placeholder' => 'Выбрать метро ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ])->label('Метро(Максимум 4)') ?>

                </div>
                <div class="col-12 col-sm-6">

                    <?= $form->field($userRayon, 'rayon_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => ArrayHelper::map(\common\models\Rayon::getAll($city['id']), 'id', 'value'),
                        'language' => 'ru',
                        'options' => ['placeholder' => 'Выбрать район ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                </div>

                <div class="col-12 col-sm-6">

                    <?= $form->field($userOsobenosti, 'param_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => ArrayHelper::map(\common\models\Osobenosti::getAll(), 'id', 'value'),
                        'language' => 'de',
                        'options' => ['placeholder' => 'Выбрать особености ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ]) ?>
                </div>

                <div class="col-12 col-sm-12 service-check-box d-flex flex-wrap">

                    <?php

                    $serviceList = \common\models\Service::getService();

                    foreach ($serviceList as $item) : ?>

                        <?php

                        $checked = '';
                        $serviceText = '';

                        if ($userService) foreach ($userService as $userServiceItem) {

                            if ($userServiceItem['service_id'] == $item['id']) {

                                $checked = 'checked';
                                $serviceText = $userServiceItem['service_info'];

                            }

                        }

                        ?>

                        <div class="service-check-box-item d-flex">
                            <input type="checkbox" id="<?php echo $item['url'] ?>" class="service-check"
                                <?= $checked ?>
                                   name="UserService[service_id][]" value="<?php echo $item['id'] ?>">
                            <label class="service-check-label" for="<?php echo $item['url'] ?>">
                                <?php echo $item['value'] ?>
                                <input type="text" placeholder="Добавить описание" value="<?= $serviceText ?>"
                                       class="service_info_input"
                                       name="UserService[service_info][<?php echo $item['id'] ?>]">
                            </label>
                        </div>

                    <?php endforeach; ?>

                </div>

                <div class="col-12 col-sm-6">

                    <?= $form->field($userPlace, 'place_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => ArrayHelper::map(\common\models\Place::getPlace(), 'id', 'value'),
                        'language' => 'de',
                        'options' => ['placeholder' => 'Выбрать место встречи...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ]) ?>

                </div>

                <div class="col-12 col-sm-6">

                    <?= $form->field($userTime, 'param_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => ArrayHelper::map(\common\models\Time::find()->all(), 'id', 'value'),
                        'language' => 'de',
                        'options' => ['placeholder' => 'Выбрать доступное время ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ])->label('Время встречи') ?>

                </div>

                <div class="col-12 col-sm-6">
                    <?= $form->field($post, 'tarif_id')
                        ->dropDownList(\yii\helpers\ArrayHelper::map($tarifList, 'id', 'value'))
                        ->label('Выберите тариф. Чем дороже тариф тем выше выводится анкета') ?>
                </div>

                <?php if (Yii::$app->requestedParams['city'] == 'moskva') : ?>
                    <div class="col-12">
                        <div class="col-12">
                            <p class="control-label">Укажите свое местоположение на карте</p>
                            <div id="map"
                                <?php if ($post->x) : ?>
                                    data-x="<?php echo $post->x ?>"
                                    data-y="<?php echo $post->y ?>"
                                <?php endif; ?>
                                 class="map" style="height: 300px">
                            </div>
                        </div>

                        <?= $form->field($post, 'x')->hiddenInput()->label(false) ?>
                        <?= $form->field($post, 'y')->hiddenInput()->label(false) ?>

                    </div>
                <?php endif; ?>

            </div>

            <?= Html::submitButton('Сохранить', ['class' => 'orange-btn d-block m-auto']) ?>

        </div>

    </div>
</div>

<?php ActiveForm::end() ?>

<div class="container">

    <div class="row">

        <div class="col-12 col-md-4">

            <?php $buyViewForm = new \frontend\modules\user\models\forms\BuyViewForm();

            if (isset($post['name']) and $post['name']) : ?>

                <?php $viewForm = ActiveForm::begin([
                    'id' => 'login-form',
                    'action' => '/cabinet/view/buy',
                    'options' => ['class' => 'form-horizontal'],
                ]) ?>

                <?= $viewForm->field($buyViewForm, 'post_id')->hiddenInput(['value' => $post->id])->label(false) ?>

                <?php

                $tarifParams = [
                    Yii::$app->params['view_100_buy_price'] => '100 показов ' . Yii::$app->params['view_100_buy_price'] . ' руб',
                    Yii::$app->params['view_1000_buy_price'] => '1000 показов ' . Yii::$app->params['view_1000_buy_price'] . ' руб',
                ];

                ?>

                <?= $viewForm->field($buyViewForm, 'price')->dropDownList($tarifParams) ?>

                <div class="form-group">
                    <?= Html::submitButton('Купить', ['class' => 'orange-btn']) ?>
                </div>
                <?php ActiveForm::end() ?>

            <?php endif; ?>

        </div>

    </div>

    <?php if ($post['readMessage']) : ?>

        <div class="row">

            <div class="col-12">

                <h3>Архив сообщений</h3>

                <?php foreach ($post['readMessage'] as $item) : ?>

                    <div class="alert alert-dark">
                        <?php echo $item['message'] ?>
                        <span class="text-left alert-small-text"> Прочитано : <?php echo date('Y-m-d', $item['updated_at']) ?></span>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    <?php endif; ?>

</div>
