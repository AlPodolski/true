<?php

/* @var $data array */

use kartik\rating\StarRating;
use yii\widgets\ActiveForm;
use frontend\modules\user\models\ReviewForm;
use frontend\modules\user\models\ServiceReviewForm;
use kartik\icons\FontAwesomeAsset;
use frontend\assets\RateAsset;

FontAwesomeAsset::register($this);

$dataRate = RateAsset::register($this);

$serviceReviewFormForm = new ServiceReviewForm();
$postReviewForm = new ReviewForm();

?>

<h5 class="modal-title" >Добавить отзыв</h5>
<div class="grey-text">
    Оцените по 5 балльной шкале качество выполненной работы и оставить отзыв.
</div>
<?php

$form = ActiveForm::begin([
    'action' => '/review/add',
    'options' => ['class' => 'form-horizontal form-comment'],
]);

echo $form->field($postReviewForm, 'post_id')->hiddenInput(['value' => $data['post']['id']])->label(false);

?>
<div class="row review-modal-body">

    <div class="col-12 reting-item">

        <div class="row">

            <div class="col-6">Фото</div>
            <div class="col-6">
                <div id="rateYo" class="rate"></div>
                <?php

                echo $form->field($postReviewForm, 'photo')->hiddenInput(['value' => 5])->label(false);

                ?>
            </div>
        </div>
    </div>
    <div class="col-12 reting-item">
        <div class="row">
            <div class="col-6">Чистота</div>
            <div class="col-6">
                <div  class="rate"></div>
                <?php

                echo $form->field($postReviewForm, 'clean')->hiddenInput(['value' => 5])->label(false);

                ?>
            </div>
        </div>
    </div>
    <div class="col-12 reting-item">
        <div class="row">
            <div class="col-6">Общая</div>
            <div class="col-6">

                <div class="rate"></div>

                <?php

                echo $form->field($postReviewForm, 'total')->hiddenInput(['value' => 5])->label(false);

                ?>

            </div>
        </div>
    </div>


    <?php foreach ($data['post']['service'] as $item) : ?>

        <div class="col-12 reting-item">
            <div class="row">

                <div class="col-6"><?php echo $item['value']?></div>
                <div class="col-6">

                    <div  class="rate"></div>
                    <?php

                        echo $form->field($serviceReviewFormForm, $item['id'])->hiddenInput(['value' => 5])->label(false);

                    ?>

                </div>

            </div>
        </div>

    <?php endforeach; ?>


    <div class="col-12">

        <?php

        echo $form->field($postReviewForm, 'name')
            ->textInput(['placeholder' => 'Ваше имя' , 'value' => Yii::$app->user->identity->username ?? ''])->label(false);

        ?>

    </div>

    <div class="col-12">

        <?php

        echo $form->field($postReviewForm, 'text')
            ->textarea(['placeholder' => 'Комментарий', 'required' => ''])->label(false);

        ?>

    </div>

    <div class="col-12">
        <div class="send-btn-wrap">
            <?= \yii\helpers\Html::submitButton('Опубликовать', ['class' => 'orange-btn']) ?>
        </div>
    </div>

</div>

<?php ActiveForm::end() ?>
<script src="<?php echo $dataRate->baseUrl.'/'.$dataRate->js[0] ?>"></script>
<link href="<?php echo $dataRate->baseUrl.'/'.$dataRate->css[0] ?>" rel="stylesheet">