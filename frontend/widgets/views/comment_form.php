<?php

use yii\widgets\ActiveForm;

/* @var $commentForm \frontend\models\forms\AddCommentForm */
/* @var $classRelatedModel string */
/* @var $classCss string */
/* @var $idCss string */
/* @var $relatedId integer */

$form = ActiveForm::begin([
    'action' => '#',
    'id' => $idCss,
    'options' => ['class' => $classCss],
]) ?>
<?= $form->field($commentForm, 'related_id',['options' => ['class' => 'd-none']])->hiddenInput(['value' => $relatedId ])->label(false) ?>
<?= $form->field($commentForm, 'text' , ['options' => ['class' => 'form-otvet']])->textarea(['placeholder' => 'Напишите что то'])->label(false) ?>
<?= $form->field($commentForm, 'class' , ['options' => ['class' => 'form-otvet']])->hiddenInput(['value' => $classRelatedModel])->label(false) ?>
<?php if (Yii::$app->user->isGuest)  $onclick = 'data-toggle="modal" data-target="#modal-in" aria-hidden="true"';
else $onclick = 'onclick="send_comment(this)"'; ?>

    <span class="send-comment-btn" <?php echo $onclick ?> data-id="<?php echo $relatedId; ?>">
        Опубликовать
    </span>

<?php ActiveForm::end() ?>