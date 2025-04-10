<?php

/* @var $this \yii\web\View */
/* @var $userParams object[] */
/* @var $phone integer|null */

/* @var $reviewForm \cabinet\modules\user\models\forms\AddPhoneReviewForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use cabinet\assets\MaskedInputAsset;
use common\models\City;
use yii\helpers\ArrayHelper;

MaskedInputAsset::register($this);

$this->title = 'Добавить отзыв';

$this->params['breadcrumbs'][] = $this->title;

?>


<div class="container">

    <div class="row">

        <div class="col-12">
            <h1 class="margin-top-20"><?php echo $this->title ?></h1>
        </div>

        <div class="col-12">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal review-call-form'],
            ]) ?>

            <div class="row form-group">
                <div class="col-12 col-sm-6 col-lg-4">
                    <?= $form->field($reviewForm, 'phone')->textInput(['value' => $phone]) ?>
                </div>

                <div class="col-12 control-label margin-bottom-30 margin-top-20">
                    Адрес выезда:
                </div>

                <div class="col-12 col-sm-5 col-lg-3">
                    <?= $form->field($reviewForm, 'city')
                        ->dropDownList(ArrayHelper::map(City::find()->all(), 'url', 'city')) ?>
                </div>

                <div class="col-12 margin-top-20">
                    <?= $form->field($reviewForm, 'text')->textarea() ?>
                </div>

                <div class="col-12 control-label margin-bottom-30 margin-top-20">
                    Тип клиента
                </div>

                <?php $i = 0 ?>

                <?php foreach ($userParams as $item) : ?>

                    <?php if ($item->parent_id == 0) : ?>

                        <?php $tempData = array() ?>

                        <?php foreach ($userParams as $secondItem) : ?>

                            <?php if ($secondItem->parent_id == $item->id) : ?>

                                <?php $info['id'] = $secondItem->id ?>
                                <?php $info['value'] = $secondItem->value ?>

                                <?php $tempData[] = $info ?>

                            <?php endif; ?>

                        <?php endforeach; ?>

                        <?php if ($tempData) { ?>

                            <div class="col-12 col-lg-4 category category-<?php echo $item->id ?>">

                                <label class="control-label"><?php echo $item->value ?></label>

                                <?php foreach ($tempData as $temItem) : ?>

                                <?php $checked = false ?>

                                <?php if ($i == 0) $checked = true ?>

                                    <?php echo Html::radio('category', $checked, ['value' => $temItem['id'],
                                        'label' => $temItem['value']])?>

                                <?php $i++; ?>

                                <?php endforeach; ?>


                            </div>

                        <?php } ?>


                    <?php endif; ?>

                <?php endforeach; ?>

                <div class="col-12">
                    <?= Html::submitButton('Добавить пробивку', ['class' => 'orange-btn d-block m-auto']) ?>
                </div>

            </div>


            <?php ActiveForm::end() ?>

        </div>

    </div>

</div>

<?php

$this->registerJs(
    "$('#addphonereviewform-phone').mask('+7(999) 999-9999');",
    $this::POS_READY,
    'my-button-handler'
);


?>


