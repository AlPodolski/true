<?php

/* @var $data array */

use kartik\rating\StarRating;
use yii\widgets\ActiveForm;
use frontend\modules\user\models\ReviewForm;
use frontend\modules\user\models\ServiceReviewForm;
use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this);

$serviceReviewFormForm = new ServiceReviewForm();
$postReviewForm = new ReviewForm();

?>

<h5 class="modal-title" id="exampleModalLabel">Добавить отзыв</h5>
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
                <?php

                echo $form->field($postReviewForm, 'photo')->widget(StarRating::className(), [
                    'value' => 8,
                    'pluginOptions' =>  [
                        'size' => 'xs',
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                        'readonly' => false,
                        'showClear' => false,
                        'showCaption' => false,
                    ],
                ])->label(false);

                ?>
            </div>
        </div>
    </div>
    <div class="col-12 reting-item">
        <div class="row">
            <div class="col-6">Чистота</div>
            <div class="col-6"><?php

                echo $form->field($postReviewForm, 'clean')->widget(StarRating::className(), [
                    'value' => 8,
                    'pluginOptions' =>  [
                        'size' => 'xs',
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                        'readonly' => false,
                        'showClear' => false,
                        'showCaption' => false,
                    ],
                ])->label(false);

                ?></div>
        </div>
    </div>
    <div class="col-12 reting-item">
        <div class="row">
            <div class="col-6">Общая</div>
            <div class="col-6"><?php

                echo $form->field($postReviewForm, 'total')->widget(StarRating::className(), [
                    'value' => 8,
                    'pluginOptions' =>  [
                        'size' => 'xs',
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                        'readonly' => false,
                        'showClear' => false,
                        'showCaption' => false,
                    ],
                ])->label(false);

                ?>
            </div>
        </div>
    </div>


    <?php foreach ($data['post']['service'] as $item) : ?>
        <div class="col-12 reting-item">
            <div class="row">

                <div class="col-6"><?php echo $item['value']?></div>
                <div class="col-6"><?php

                    echo $form->field($serviceReviewFormForm, $item['id'])->widget(StarRating::className(), [
                        'value' => 8,
                        'pluginOptions' =>  [
                            'size' => 'xs',
                            'min' => 0,
                            'max' => 10,
                            'step' => 1,
                            'readonly' => false,
                            'showClear' => false,
                            'showCaption' => false,
                        ],
                    ])->label(false);

                    ?></div>

            </div>
        </div>

    <?php endforeach; ?>


    <div class="col-12">

        <?php

        echo $form->field($postReviewForm, 'text')
            ->textarea(['placeholder' => 'Комментарий'])->label(false);

        ?>

    </div>

    <div class="col-12">
        <div class="send-btn-wrap">
            <?= \yii\helpers\Html::submitButton('Опубликовать', ['class' => 'orange-btn']) ?>
        </div>
    </div>

</div>

<?php ActiveForm::end() ?>