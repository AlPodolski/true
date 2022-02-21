<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Posts */
/* @var $form yii\widgets\ActiveForm */
/* @var $postMessageModel \common\models\PostMessage */

$tarifList = array();

foreach (\common\models\Tarif::getAll() as $item){

    $tarifList[] = array( 'id' => $item['id'], 'value' => $item['value'] . ' - ' . $item['sum'].' руб. в час' );

}

?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-4">
            <?= $form->field($model, 'city_id')->textInput() ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'user_id')->textInput() ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'status')->dropDownList(
                [
                    \frontend\modules\user\models\Posts::POST_ON_MODARATION_STATUS => 'Ожидает проверки',
                    \frontend\modules\user\models\Posts::POST_ON_PUPLICATION_STATUS => 'Публикуется',
                    \frontend\modules\user\models\Posts::POST_DONT_PUBLICATION_STATUS => 'Не публикуется',
                    \frontend\modules\user\models\Posts::RETURNED_FOR_REVISION => 'На доработке',
                ])
            ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'tarif_id')
                ->dropDownList(\yii\helpers\ArrayHelper::map($tarifList, 'id' , 'value'))
                ->label('Выберите тариф')?>

        </div>

        <div class="col-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'category')->dropDownList(
                [
                    \frontend\modules\user\models\Posts::INDI_CATEGORY => 'Инди',
                    \frontend\modules\user\models\Posts::SALON_CATEGORY => 'Салон',
                ])
            ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'retouching_photo_status')->dropDownList(
                [
                    \frontend\modules\user\models\Posts::WITH_RETOUCHING_PHOTO_STATUS => 'Статус по умолчанию',
                    \frontend\modules\user\models\Posts::NOT_RETOUCHING_PHOTO_STATUS => 'Фото без ретуши',
                ])
            ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'check_photo_status')->dropDownList(
                [
                    \frontend\modules\user\models\Posts::ANKET_NOT_CHECK => 'Личность не подтверждена',
                    \frontend\modules\user\models\Posts::ANKET_CHECK => 'Личность подтверждена',
                ])
            ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'age')->textInput() ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'rost')->textInput() ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'breast')->textInput() ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'ves')->textInput() ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'about')->textarea(['rows' => 3]) ?>
        </div>

        <?php if ($postMessageModel) : ?>

            <div class="col-12">
                <?= $form->field($postMessageModel, 'message')->textarea(['rows' => 2])
                    ->label('Прикрепить сообщение') ?>
            </div>
            <div class="col-12">
                <?= $form->field($postMessageModel, 'post_id')->hiddenInput(['value' => $model->id])
                    ->label(false) ?>
            </div>

        <?php endif; ?>

        <?php if (isset($model->checkPhoto) and $model->checkPhoto) : ?>

            <div class="col-12"><label class="control-label">Проверочное фото</label></div>

                <div class="col-4 position-relative">

                    <?php echo Html::img('http://moskva.'.Yii::$app->params['site_name'] .$model->checkPhoto->file); ?>

                </div>

        <?php endif; ?>

        <?php if (isset($model->allPhoto) and $model->allPhoto) : ?>

            <div class="col-12"><label class="control-label">Фото</label></div>

            <?php foreach ($model->allPhoto as $item) : ?>

                <div class="col-2 position-relative">

                    <?php echo Html::img('http://moskva.'.Yii::$app->params['site_name'] .$item->file); ?>

                    <?php if ($item->main == \frontend\models\Files::MAIN_PHOTO) : ?>

                        <span class="main-photo">Главное фото</span>

                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

        <?php if (isset($model->video) and $model->video) : ?>

            <div class="col-4">
                <label class="control-label">Видео</label>
                <video controls="controls" class="video">
                    <source src="http://moskva.<?php echo Yii::$app->params['site_name'] .$model->video ?>">
                </video>
            </div>

        <?php endif; ?>

    </div>

    <?php if (isset($model->created_at)) : ?>

        <p>Создано <?php echo date('Y-m-d H:i:s', $model->created_at)?></p>

        <?php if ($model->updated_at != $model->created_at) : ?>

            <p>Обновлено <?php echo date('Y-m-d H:i:s', $model->updated_at)?></p>

        <?php endif; ?>

    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверенны?',
            'method' => 'post',
        ],
    ]) ?>

    </div>


</div>
<?php //d($model); ?>