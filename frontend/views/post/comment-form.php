<?php

/* @var $data array */

use yii\widgets\ActiveForm;
use frontend\modules\user\models\ReviewForm;
use frontend\modules\user\models\ServiceReviewForm;
use kartik\icons\FontAwesomeAsset;
use frontend\assets\RateAsset;

FontAwesomeAsset::register($this);

RateAsset::register($this);

$serviceReviewFormForm = new ServiceReviewForm();
$postReviewForm = new ReviewForm();

?>

<p class="modal-title">Добавить отзыв</p>
<div class="grey-text">
    Оцените по 5 балльной шкале качество выполненной работы и оставить отзыв.
</div>
<?php

$form = ActiveForm::begin([
    'action' => '/review/add',
    'options' => ['class' => 'form-horizontal form-comment'],
]);

echo $form->field($postReviewForm, 'post_id')->hiddenInput(['value' => $post['id']])->label(false);

?>
<div class="row review-modal-body ">

    <div class="col-12 reting-item">

        <div class="raiting-item-text">Фото</div>
        <div id="rateYo" class="rate"></div>
        <?php
        echo $form->field($postReviewForm, 'photo')->hiddenInput(['value' => 5])->label(false);
        ?>
    </div>
    <div class="col-12 reting-item">

        <div class="raiting-item-text">Чистота</div>
        <div class="rate"></div>
        <?php

        echo $form->field($postReviewForm, 'clean')->hiddenInput(['value' => 5])->label(false);
        ?>

    </div>
    <div class="col-12 reting-item">

        <div class="raiting-item-text">Общая</div>
        <div class="rate"></div>

        <?php
        echo $form->field($postReviewForm, 'total')->hiddenInput(['value' => 5])->label(false);
        ?>
    </div>

    <div class="col-12">

        <?php
        echo $form->field($postReviewForm, 'name')
            ->textInput(['placeholder' => 'Ваше имя', 'required' => ''])->label(false);
        ?>

    </div>
    <div class="col-12">

        <?php

        echo $form->field($postReviewForm, 'text')
            ->textarea(['placeholder' => 'Комментарий', 'required' => ''])->label(false);

        ?>

    </div>

    <div class="col-12">

        <?= \yii\helpers\Html::submitButton('Опубликовать', ['class' => 'orange-btn']) ?>

    </div>

</div>

<?php ActiveForm::end() ?>
